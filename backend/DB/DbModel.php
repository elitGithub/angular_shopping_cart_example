<?php


namespace App\DB;


use App\Application;
use App\Model;
use Exception;
use PDO;
use PDOException;
use PDOStatement;

abstract class DbModel extends Model
{
    public static int $limitPerPage = 50;

    abstract public static function tableName(): string;

    abstract public function attributes(): array;

    abstract public function fillable(): array;

    abstract public static function primaryKey(): string;


    public function save(): bool
    {
        try {
            $tableName = static::tableName();
            $attributes = $this->fillable();
            $params = array_map(fn($attr) => ":$attr", $attributes);
            $statement = static::prepare("INSERT INTO $tableName (" . implode(',',
                    $attributes) . ") VALUES (" . implode(',', $params) . ");");
            foreach ($attributes as $attribute) {
                $statement->bindValue(":$attribute", $this->{$attribute});
            }
            $statement->execute();
            return true;
        } catch (Exception | PDOException $e) {
            if (method_exists($this, 'logErrors')) {
                // TODO: add log!
                $this->logErrors($e->getMessage(), $e->getTraceAsString());
            }
            return false;
        }
    }

    protected function logErrors($message, $trace)
    {
        file_put_contents(Application::$ROOT_DIR . '/runtime/errors_log.txt',
            ['message' => $message, 'trace' => $trace],
            FILE_APPEND);
    }

    public function exec(string $sql): bool|int
    {
        return Application::$app->db->pdo->exec($sql);
    }

    public static function prepare($sql): bool|PDOStatement
    {
        return Application::$app->db->pdo->prepare($sql);
    }

    public static function findAll($offset = 0): array
    {
        $tableName = static::tableName();
        $limit = static::$limitPerPage;
        $instance = new static();
        $tableAttributes = $instance->modelAttributes();
        $where = '';
        if (in_array('deleted', $tableAttributes)) {
            $where .= ' WHERE deleted = ' . static::NOT_DELETED;
        }

        $stmt = static::prepare("SELECT * FROM $tableName $where LIMIT $offset, $limit");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?? [];
    }

    public function modelAttributes(): array
    {
        $stmt = static::prepare("DESCRIBE {$this->tableName()}");
        $stmt->execute();
        $attributes = [];
        foreach ($stmt->fetchAll() as $index => $row) {
            $attributes[] = $row['Field'];
        }
        return $attributes;
    }

    public static function findOne(array $where = [])
    {
        $tableName = static::tableName();
        $attributes = array_keys($where);
        $sqlWhere = implode(" AND ", array_map(fn($attr) => "$attr = :$attr", $attributes));
        $stmt = static::prepare("SELECT * FROM $tableName WHERE $sqlWhere");
        foreach ($where as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }

        $stmt->execute();
        return $stmt->fetchObject(static::class);
    }
}