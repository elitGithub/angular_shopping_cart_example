<?php


namespace App\DB;


use App\Application;
use App\Exceptions\TooFewArgumentsSupplied;
use App\Exceptions\TooManyArgsException;
use PDO;
use PDOException;
use PDOStatement;

/**
 * Class Database
 * @package eligithub\phpmvc\DB
 */
class Database
{

    public PDO $pdo;

    public int $batch = 1;

    protected string $table;
    protected string | array $columns;
    /**
     * @var mixed|string
     */
    protected mixed $alias;
    protected array | string $where;
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
    private bool $debug = false;

    public function __construct (array $config)
    {
        $this->checkAndCreateDB();
        $dsn = $config['dsn'] ?? '';
        $user = $config['user'] ?? '';
        $password = $config['password'] ?? '';
        $options = [
            PDO::ATTR_PERSISTENT         => true,
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ];
        try {
            $this->pdo = new PDO($dsn, $user, $password, $options);
        } catch (PDOException $e) {
            echo $e->getMessage();
            die();
        }
    }

    public function preparedQuery (string $sql, array $params = [], $dieOnError = false) : bool | PDOStatement
    {
        if (empty($params)) {
            // No need for preparation - no prepared statement.
            return $this->query($sql);
        }

        $stmt = $this->pdo->prepare($sql);
        if (isset($params[0])) {
            // Question marks
            $params = $this->flatten_array($params);
            $res = $stmt->execute($params);
            if (!$res && $dieOnError) {
                if ($this->debug) {
                    echo $this->toSql($sql, $params, true);
                }
                die('Query failed');
            }
            return $stmt;
        }

        // Named params
        foreach ($params as $param => $value) {
            $type = $this->paramType($value);
            $stmt->bindValue(":$param", $value, $type);
        }
        $res = $stmt->execute();
        if (!$res && $dieOnError) {
            if ($this->debug) {
                echo $this->toSql($sql, $params, true);
            }
            die('Query failed');
        }
        return $stmt;
    }

    /**
     * @param       $query
     * @param       $data
     * @param  bool  $die
     *
     * @return array|string|null Replace placeholders with the provided values.
     * Replace placeholders with the provided values.
     */
    public function toSql ($query, $data, bool $die = false) : array | string | null
    {
        $keys = [];
        $values = $data;
        $named_params = true;
        # build a regular expression for each parameter
        foreach ($data as $key => $value) {
            if (is_string($key)) {
                $keys[] = '/:' . $key . '/';
            } else {
                $keys[] = '/[?]/';
                $named_params = false;
            }

            if (is_string($value)) {
                $values[$key] = "'" . $value . "'";
            }

            if (is_array($value)) {
                $values[$key] = "'" . implode("','", $value) . "'";
            }

            if (is_null($value)) {
                $values[$key] = 'NULL';
            }
        }

        if ($named_params) {
            $query = preg_replace($keys, $values, $query);
        } else {
            $query = $query . ' ';
            $bits = explode(' ? ', $query);

            $query = '';
            for ($i = 0; $i < count($bits); $i++) {
                $query .= $bits[$i];

                if (isset($values[$i])) {
                    $query .= ' ' . $values[$i] . ' ';
                }
            }
        }

        if ($die) {
            die($query);
        }

        return $query;
    }

    public function flatten_array ($input, $output = null)
    {
        if (empty($input)) {
            return null;
        }
        if (empty($output)) {
            $output = [];
        }
        foreach ($input as $value) {
            if (is_array($value)) {
                $output = $this->flatten_array($value, $output);
            } else {
                array_push($output, $value);
            }
        }
        return $output;
    }

    private function query (string $sql) : bool | PDOStatement
    {
        return $this->pdo->query($sql);
    }

    /**
     * @param  PDOStatement  $result
     *
     * @return mixed
     */
    public function fetchSingleColumn (PDOStatement $result) : mixed
    {
        return $result->fetch(PDO::FETCH_COLUMN);
    }

    /**
     * @param  PDOStatement  $result
     *
     * @return bool|array
     */
    public function fetchAllColumns (PDOStatement $result) : bool | array
    {
        return $result->fetchAll(PDO::FETCH_COLUMN);
    }

    protected function paramType ($value) : int
    {
        return match (true) {
            is_int($value) => PDO::PARAM_INT,
            is_bool($value) => PDO::PARAM_BOOL,
            is_null($value) => PDO::PARAM_NULL,
            default => PDO::PARAM_STR,
        };
    }

    public static function prepare ($sql) : bool | PDOStatement
    {
        return Application::$app->db->pdo->prepare($sql);
    }

    public function table (string $table) : static
    {
        $this->table = $table;
        return $this;
    }

    /**
     * @throws TooManyArgsException
     * @throws TooFewArgumentsSupplied
     */
    public function where () : static
    {
        $args = func_get_args();

        // TODO: bind?! Validation!?
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

    // TODO: there has got to be a better way of doing this...
    public function count ($alias = '') : array | bool
    {
        $this->columns = 'COUNT(*)';
        if (!empty($alias)) {
            $this->columns = 'COUNT(*) AS ' . $alias;
        }
        $sql = "SELECT $this->columns FROM $this->table";

        if (!empty($this->where)) {
            $sql .= " WHERE " . join(' AND ', $this->where) . " ";
        }

        $stmt = static::prepare(rtrim($sql, 'and'));
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    //TODO: we'll need to make this into a smarter select.
    protected function get (array | string $columns = ['*']) : static
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

    public function select () : bool | array
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

    public function whereIn ($column)
    {
    }

    private function createWhere (array $args) : string
    {
        return match (strtoupper($args[1])) {
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
            'STARTS WITH' => "$args[1] LIKE $args[2]%",
            default => "$args[1] = $args[2]",
        };
    }

    private function checkAndCreateDB () : void
    {
        $dsn = 'mysql:host=' . $_ENV['DB_HOST'] . ';port=' . $_ENV['DB_PORT'];
        $user = $_ENV['DB_USER'];
        $password = $_ENV['DB_PASSWORD'];
        $options = [
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE    => PDO::ERRMODE_EXCEPTION,
        ];
        try {
            $pdo = new PDO($dsn, $user, $password, $options);
        } catch (PDOException $e) {
            echo $e->getMessage();
            die();
        }

        $stmt = $pdo->prepare("SHOW DATABASES LIKE ?;");
        $stmt->bindParam(1, $_ENV['DB_NAME']);
        $stmt->execute();
        if (sizeof($stmt->fetchAll()) < 1) {
            $pdo->exec("CREATE DATABASE IF NOT EXISTS {$_ENV['DB_NAME']};");
        }
    }
}