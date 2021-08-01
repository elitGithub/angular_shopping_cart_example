<?php

namespace App\DB;

use App\Application;
use App\Exceptions\TooFewArgumentsSupplied;
use App\Exceptions\TooManyArgsException;
use App\Model;
use PDO;
use PDOStatement;

class RepositoryModel extends Model
{
    protected string $table;
    protected string|array $columns;
    /**
     * @var mixed|string
     */
    protected mixed $alias;
    protected array|string $where;
    private array $sqlComparisonOperators = [
        '=',
        '<>',
        '>',
        '<',
        '!=',
        '>=',
        '<=',
        'LIKE',
        'NOT LIKE',
        'IS NOT NULL',
        'IS NULL',
    ];

    public function rules(): array
    {
        return [];
    }

    public function raw($sql)
    {
        $stmt = static::prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function exec(string $sql): bool|int
    {
        return Application::$app->db->pdo->exec($sql);
    }

    public static function prepare($sql): bool|PDOStatement
    {
        return Application::$app->db->pdo->prepare($sql);
    }

    public function table(string $table): static
    {
        $this->table = $table;
        return $this;
    }

    protected function where(): static
    {
        $args = func_get_args();

        if (empty($args)) {
            throw new TooFewArgumentsSupplied();
        }
        if (sizeof($args) > 3) {
            throw new TooManyArgsException();
        }
        if (is_array($args[0])) {
            $this->where[] = $args[0];
        }

        if (in_array($args[1], $this->sqlComparisonOperators)) {
            $this->where[] = $this->createWhere($args);
        } else {
            $this->where[] = "$args[0] = $args[1]";
        }


        return $this;
    }

    protected function count($alias = ''): array|bool
    {
        $this->columns = 'COUNT(*)';
        if (!empty($alias)) {
            $this->columns = 'COUNT(*) AS ' . $alias;
        }
        $sql = "SELECT $this->columns FROM $this->table";

        if (!empty($this->where)) {
            $sql .= " WHERE " . join(' AND ', $this->where) . " ";
        }

        $stmt = static::prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    //TODO: we'll need to make this into a smarter select.
    protected function get(array|string $columns = ['*']): static
    {
        if (is_array($columns)) {
            $columns = join(', ', $columns);
        }
        $this->columns = $columns;
        if (!empty($alias)) {
            $this->alias = $alias;
        }
        return $this;
    }

    public function select(): bool|array
    {
        $columnList = $this->columns;
        if (is_array($this->columns)) {
            $columnList = join(',', $this->columns);
        }
        $sql = "SELECT $columnList FROM $this->table";

        if (!empty($this->where)) {
            $sql .= " WHERE " . join(' AND ', $this->where) . " ";
        }

        if (!empty($this->limits)) {
            $sql .= " $this->limits ";
        }
        $stmt = static::prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    private function createWhere(array $args): string
    {
        return match ($args[1]) {
            '<>' => "$args[1] <> $args[2]",
            '>' => "$args[1] > $args[2]",
            '<' => "$args[1] < $args[2]",
            '!=' => "$args[1] != $args[2]",
            '>=' => "$args[1]>=$args[2]",
            '<=' => "$args[1]<=$args[2]",
            'LIKE' => "$args[1] LIKE %$args[2]%",
            'NOT LIKE' => "$args[1] NOT LIKE %$args[2]%",
            'IS NULL' => "$args[1] IS NULL",
            'IS NOT NULL' => "$args[1] IS NOT NULL",
            default => "$args[1] = $args[2]",
        };
    }

}
