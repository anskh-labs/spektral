<?php

declare(strict_types=1);

namespace Faster\Console;

use Exception;
use Faster\Component\Enums\DatabaseEnum;
use Faster\Console\CommandInterface;
use Faster\Db\Database;
use PDO;

/**
 * Migration Command
 * -----------
 * Class to handle migration in shell
 *
 * @author Khaerul Anas <khaerulanas@live.com>
 * @since 1.0.0
 * @package Faster\Console
 */
class MigrationCommand implements CommandInterface
{
    private string $table;
    private string $path;

    /**
     * __construct
     *
     * @param  \Faster\Db\Database $db
     * @param  string $migrationTable
     * @param  string $migrationPath
     * @return void
     */
    public function __construct(private Database $db, string $migrationTable, string $migrationPath)
    {
        $this->table = $this->db->getTable($migrationTable);
        if (is_dir($migrationPath)) {
            $this->path = $migrationPath;
        } else {
            throw new \Exception("Migration path '$migrationPath' is not exist");
        }
    }

    /**
     * @inheritdoc
     */
    public function execute(string $action): void
    {
        try {

            $this->createIfNotExistMigrationsTable();

            $appliedMigrations = $this->getAppliedMigrations($action);

            $newMigrations = [];
            $path = $this->path;
            $files = scandir($path);
            if (is_array($files)) {
                $toApplyMigrations = array_diff($files, $appliedMigrations);

                foreach ($toApplyMigrations as $migration) {
                    if ($migration === '.' || $migration === '..') {
                        continue;
                    }

                    require_once $path . "/{$migration}";
                    $className = pathinfo($migration, PATHINFO_FILENAME);
                    $instance = make($className, [$this->db]);
                    $this->log("Applying migration {$action} {$migration}");
                    if ($instance->{$action}()) {
                        if ($action !== 'seed') {
                            $this->db->delete($this->table, "migration='{$migration}'");
                        } else {
                            $this->db->delete($this->table, "migration='{$migration}' and action='down'");
                        }
                        $newMigrations[] = $migration;
                        $this->log("Applied migration {$action} {$migration}");
                    } else {
                        $this->log("No applyable migration {$action} {$migration}");
                    }
                }
            } else {
                $this->log("No files to migrate.");
            }

            if (!empty($newMigrations)) {
                $this->saveMigrations($newMigrations, $action);
            } else {
                $this->log("All migrations are applied");
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    /**
     * createIfNotExistMigrationsTable
     *
     * @return void
     */
    protected function createIfNotExistMigrationsTable():void
    {
        $type = $this->db->getType();
        $columns = [];
        $primary = [];
        $unique = [];

        switch ($type) {
            case DatabaseEnum::MYSQL:
                $columns['id'] = 'INT UNSIGNED NOT NULL AUTO_INCREMENT';
                $columns['migration'] = 'VARCHAR(255) NOT NULL';
                $columns['action'] = 'VARCHAR(20) NOT NULL';
                $columns['create_at'] = 'TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP';
                $primary[] = 'id';
                $unique[] = 'migration';
                $unique[] = 'action';
                break;
            case DatabaseEnum::SQLITE:
                $columns['id'] = 'INTEGER NOT NULL';
                $columns['migration'] = 'VARCHAR(255) NOT NULL';
                $columns['action'] = 'VARCHAR(20) NOT NULL';
                $columns['create_at'] = 'TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP';
                $primary[] = 'id';
                $unique[] = 'migration';
                $unique[] = 'action';
                break;
            case DatabaseEnum::SQLSRV:
                $columns['id'] = 'INT IDENTITY';
                $columns['migration'] = 'VARCHAR(255) NOT NULL';
                $columns['action'] = 'VARCHAR(20) NOT NULL';
                $columns['create_at'] = 'DATETIME NOT NULL DEFAULT GETDATE()';
                $primary[] = 'id';
                $unique[] = 'migration';
                $unique[] = 'action';
                break;
            case DatabaseEnum::PGSQL:
                $columns['id'] = 'SERIAL';
                $columns['migration'] = 'VARCHAR(255) NOT NULL';
                $columns['action'] = 'VARCHAR(20) NOT NULL';
                $columns['create_at'] = 'TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP';
                $primary[] = 'id';
                $unique[] = 'migration';
                $unique[] = 'action';
                break;
            default:
        }
        $this->db->createIfNotExist($this->table, $columns, $primary, $unique);
    }
    /**
     * getAppliedMigrations
     *
     * @param  string $action
     * @return array
     */
    protected function getAppliedMigrations(string $action): array
    {
        return $this->db->select($this->table, 'migration',  "action='{$action}'", 0, -1, null, PDO::FETCH_COLUMN);
    }
    /**
     * saveMigrations
     *
     * @param  array $migrations
     * @param  string $action
     * @return void
     */
    protected function saveMigrations(array $migrations, string $action)
    {
        $data = array_map(fn ($migration) => ['migration' => $migration, 'action' => $action], $migrations);
        $this->db->insert($data, $this->table, true);
    }

    /**
     * log
     *
     * @param  string $message
     * @return void
     */
    protected function log(string $message)
    {
        echo '[' . date('Y-m-d H:i:s') . '] - ' . $message . PHP_EOL;
    }
}
