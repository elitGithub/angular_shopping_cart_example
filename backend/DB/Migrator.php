<?php

namespace App\DB;

use App\Application;
use App\Migration;
use Exception;
use PDO;

class Migrator extends Database
{
    private array $skipMigrations = ['.', '..'];
    public function applyMigrations()
    {
        $this->createMigrationsTable();
        $this->currentBatch();
        $appliedMigrations = $this->getAppliedMigrations();

        $files = scandir(Application::$ROOT_DIR . DIRECTORY_SEPARATOR . Migration::$migrationsDir);

        $toApplyMigrations = array_diff($files, $appliedMigrations);
        foreach ($toApplyMigrations as $migration) {
            if (in_array($migration, $this->skipMigrations)) {
                continue;
            }

            require_once Application::$ROOT_DIR . DIRECTORY_SEPARATOR . Migration::$migrationsDir . DIRECTORY_SEPARATOR . $migration;
            $className = pathinfo($migration, PATHINFO_FILENAME);
            $this->addNameSpace($className);
            $instance = new $className();

            $this->consoleOutput("Migrating $migration");
            try {
                $instance->up();
                $this->consoleOutput("Migrated $migration");
                $newMigrations[] = $migration;
            } catch (Exception $e) {
                $this->consoleOutput($e->getMessage());
                continue;
            }

        }

        if (!empty($newMigrations)) {
            $this->saveMigrations($newMigrations);
        } else {
            $this->consoleOutput("No new migrations to apply");
        }
    }

    public function reverseMigrations()
    {
        $result = $this->preparedQuery('SELECT migration FROM migrations WHERE batch IN (SELECT MAX(batch) AS batch FROM migrations);');
        $migrations = $this->fetchAllColumns($result);

        foreach ($migrations as $migration) {
            require_once Application::$ROOT_DIR . DIRECTORY_SEPARATOR . Migration::$migrationsDir . DIRECTORY_SEPARATOR . $migration;
            $className = pathinfo($migration, PATHINFO_FILENAME);
            $this->addNameSpace($className);
            $instance = new $className();

            $this->consoleOutput("Rolling Back $migration");
            $instance->down();
            $this->consoleOutput("Rolled Back $migration");
            $reversedMigrations[] = $migration;
        }

        if (!empty($reversedMigrations)) {
            $this->deleteMigrations($reversedMigrations);
        } else {
            $this->consoleOutput('No migrations to roll back');
        }
    }

    public function createMigrationsTable()
    {
        $this->pdo->exec("CREATE TABLE IF NOT EXISTS migrations (
    			id INT AUTO_INCREMENT PRIMARY KEY,
    			migration VARCHAR(255),
    			batch INT,
    			created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP)
    			ENGINE=INNODB");
    }

    protected function getAppliedMigrations(): array
    {
        $result = $this->preparedQuery("SELECT migration FROM migrations;");
        return $this->fetchAllColumns($result);
    }

    protected function addNameSpace(array|string &$className)
    {
        if (is_string($className)) {
            $className = "\\App\\".Migration::$migrationsDir. "\\$className";
        }
    }

    protected function saveMigrations(array $migrations)
    {
        $values = join(',', array_map(fn($m) => "('$m', $this->batch)", $migrations));
        $stmt = $this->pdo->prepare("INSERT INTO migrations (migration, batch) VALUES $values");
        $stmt->execute();
    }

    protected function deleteMigrations(array $migrations)
    {
        $toDelete = join(',', array_map(fn($m) => "'$m'", $migrations));
        $this->preparedQuery("DELETE FROM migrations WHERE migration IN ($toDelete)");
    }

    protected function consoleOutput(string $message)
    {
        echo '[' . date('Y-m-d H:i:s') . '] - ' . $message . PHP_EOL;
    }

    private function currentBatch()
    {
        $result = $this->preparedQuery('SELECT MAX(batch) as batch FROM migrations');
        $max = $this->fetchColumn($result);
        $this->batch = ++$max;
    }

}