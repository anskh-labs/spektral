<?php

declare(strict_types=1);

namespace Faster\Db;

use Faster\Component\Contract\MultitonTrait;
use Faster\Component\Enums\DatabaseEnum;
use Faster\Helper\Db;
use PDO;
use PDOStatement;

/**
 * Database
 * -----------
 * Class for working with database
 *
 * @author Khaerul Anas <khaerulanas@live.com>
 * @since 1.0.0
 * @package Faster\Db
 */
class Database
{
    use MultitonTrait;

    private PDO $pdo;
    private string|null $prefix;
    private string $type;

    /**
     * __construct
     *
     * @param  string $name
     * @return void
     */
    final private function __construct(private string $name)
    {
        $config = Db::options($name);
        $dsn = $config[Db::DSN] ?? '';
        $username = $config[Db::USERNAME] ?? null;
        $password = $config[Db::PASSWORD] ?? null;
        $pdo_options = $config[Db::PDO_OPTIONS] ?? null;
        $this->pdo = new PDO($dsn, $username, $password, $pdo_options);
        $this->prefix = $config[Db::TABLE_PREFIX] ?? null;
        $this->type = $this->pdo->getAttribute(PDO::ATTR_DRIVER_NAME);
    }
    final function __clone()
    {
    }
    final function __wakeup()
    {
    }
    /**
     * exec
     *
     * @param  string $sql
     * @return int|false
     */
    public function exec(string $sql): int|false
    {
        return $this->pdo->exec($sql);
    }
    /**
     * query
     *
     * @param  string $sql
     * @return PDOStatement|false
     */
    public function query(string $sql): PDOStatement|false
    {
        return $this->pdo->query($sql);
    }
    /**
     * getConnectionName
     *
     * @return string
     */
    public function getConnectionName(): string
    {
        return $this->name;
    }
    /**
     * getDbPrefix
     *
     * @return string
     */
    public function getDbPrefix(): string
    {
        return $this->prefix ?? '';
    }
    /**
     * getTable
     *
     * @param  string $table
     * @return string
     */
    public function getTable(string $table): string
    {
        return $this->e($this->prefix . $table);
    }
    /**
     * insert
     *
     * @param  array $data
     * @param  string $table
     * @param  bool $insertBatch
     * @return int
     */
    public function insert(array $data, string $table, bool $insertBatch = false): int
    {
        $affectedRows = 0;

        if (!$data) {
            return $affectedRows;
        }

        if ($insertBatch) {
            foreach ($data as $row) {
                $affectedRows += $this->insert($row, $table);
            }
        } else {
            $data = array_filter($data, function ($val) {
                return is_null($val) ? false : true;
            });
            $keys = array_keys($data);
            $sql = "INSERT INTO $table(" .  implode(',', array_map(fn ($attr) => $this->e($attr), $keys)) . ")VALUES(" . implode(',', array_fill(0, count($keys), '?')) . ");";
            $stmt = $this->pdo->prepare($sql);
            if ($stmt->execute(array_values($data))) {
                $affectedRows += $stmt->rowCount();
            }
        }

        return $affectedRows;
    }
    /**
     * update
     *
     * @param  array $data
     * @param  string $table
     * @param  array|string|null $where
     * @return int
     */
    public function update(array $data, string $table, array|string|null $where = null): int
    {
        $affectedRows = 0;

        if (!$data) {
            return $affectedRows;
        }

        $nullString = '';
        $filterData = [];
        foreach ($data as $key => $val) {
            if (is_null($val)) {
                $nullString .= "$key=NULL,";
            } else {
                $filterData[$key] = $val;
            }
        }

        if (!empty($filterData)) {
            $sql = "UPDATE $table SET $nullString" . implode(',', array_map(fn ($attr) => $this->e($attr) . "=?", array_keys($filterData)));
        } else {
            $nullString = rtrim($nullString, ',');
            $sql = "UPDATE $table SET $nullString";
        }

        $criteria = is_array($where) ? QueryHelper::parseWhere($where) : $where ?? '';
        if ($criteria) {
            $criteria = ' WHERE ' . $criteria;
        }
        $sql .= $criteria;

        $stmt = $this->pdo->prepare($sql . ";");

        $params = is_array($where) ? array_merge(array_values($filterData), QueryHelper::parseParams($where)) : array_values($filterData);
        $params = array_filter($params, function ($val) {
            return is_null($val) ? false : true;
        });
        if ($stmt->execute($params)) {
            return $stmt->rowCount();
        }

        return $affectedRows;
    }
    /**
     * delete
     *
     * @param  string $table
     * @param  array|string|null $where
     * @return int
     */
    public function delete(string $table, $where = null): int
    {
        $sql = "DELETE FROM $table";
        $criteria = is_array($where) ? QueryHelper::parseWhere($where) : $where ?? '';
        if ($criteria) {
            $criteria = ' WHERE ' . $criteria;
        }
        $sql .= $criteria;
        $stmt = $this->pdo->prepare($sql . ";");
        if (is_array($where)) {
            $values = QueryHelper::parseParams($where);
            if ($stmt->execute($values)) {
                return $stmt->rowCount();
            }
        } else {
            if ($stmt->execute()) {
                return $stmt->rowCount();
            }
        }

        return 0;
    }
    /**
     * select
     *
     * @param  string $table
     * @param  string $column
     * @param  array|string|null $where
     * @param  int $limit
     * @param  int $offset
     * @param  string|null $orderby
     * @param  int $fetch
     * @return array
     */
    public function select(string $table, string $column = '*', array|string|null $where = null, int $limit = 0, int $offset = -1, string|null $orderby = null, int $fetch = PDO::FETCH_ASSOC): array
    {
        $sql = "SELECT $column FROM $table";
        $criteria = is_array($where) ? QueryHelper::parseWhere($where) : $where ?? '';
        if ($criteria) {
            $criteria = ' WHERE ' . $criteria;
        }
        $sql .= $criteria;
        $result = [];

        if ($orderby) {
            $sql .= " ORDER BY " . $orderby;
        }

        if ($offset >= 0) {
            $sql .= " LIMIT {$offset}";
            if ($limit > 0) {
                $sql .= ",{$limit}";
            }
        }

        $stmt = $this->pdo->prepare($sql . ";");
        if (is_array($where)) {
            $values = QueryHelper::parseParams($where);
            $stmt->execute($values);
        } else {
            $stmt->execute();
        }
        if ($limit === 1) {
            $result = $stmt->fetch($fetch);
        } else {
            $result = $stmt->fetchAll($fetch);
        }

        return is_array($result) ?  $result : [];
    }
    /**
     * getRow
     *
     * @param  string $table
     * @param  string $column
     * @param  array|string|null $where
     * @return array
     */
    public function getRow(string $table, string $column = '*', array|string|null $where = null): array
    {
        return $this->select($table, $column, $where, 1);
    }
    /**
     * getColumn
     *
     * @param  string $table
     * @param  string $column
     * @param  array|string|null $where
     * @return mixed
     */
    public function getColumn(string $table, string $column, array|string|null $where = null): mixed
    {
        $sql = "SELECT $column FROM $table";
        $criteria = is_array($where) ? QueryHelper::parseWhere($where) : $where ?? '';
        if ($criteria) {
            $criteria = ' WHERE ' . $criteria;
        }
        $sql .= $criteria;

        $stmt = $this->pdo->prepare($sql . ";");
        if (is_array($where)) {
            $values = QueryHelper::parseParams($where);
            $stmt->execute($values);
        } else {
            $stmt->execute();
        }
        
        return $stmt->fetchColumn();
    }
    /**
     * getRecordCount
     *
     * @param  string $table
     * @param  array|string|null $where
     * @return int
     */
    public function getRecordCount(string $table, $where = null): int
    {
        $criteria = is_array($where) ? QueryHelper::parseWhere($where) : $where ?? '';
        if ($criteria) {
            $criteria = ' WHERE ' . $criteria;
        }
        $stmt = $this->pdo->prepare('SELECT COUNT(FOUND_ROWS()) as `record_count` FROM ' . $table . $criteria);
        if (is_array($where)) {
            $values = QueryHelper::parseParams($where);
            $stmt->execute($values);
        } else {
            $stmt->execute();
        }
        $result = $stmt->fetch(PDO::FETCH_COLUMN);

        return is_bool($result) ? 0 : intval($result);
    }

    /**
     * recordExists
     *
     * @param  string $table
     * @param  array|string|null $where
     * @return bool
     */
    public function recordExists(string $table, $where = null): bool
    {
        $criteria = is_array($where) ? QueryHelper::parseWhere($where) : $where ?? '';
        if ($criteria) {
            $criteria = ' WHERE ' . $criteria;
        }
        $stmt = $this->pdo->prepare('SELECT EXISTS(SELECT * FROM ' . $table . $criteria . ' LIMIT 1) as `is_exists`');
        if (is_array($where)) {
            $values = QueryHelper::parseParams($where);
            $stmt->execute($values);
        } else {
            $stmt->execute();
        }
        $result = $stmt->fetch(PDO::FETCH_COLUMN);

        return intval($result) === 1 ? true : false;
    }
    /**
     * drop
     *
     * @param  string $table
     * @param  bool $checkExist
     * @return bool
     */
    public function drop(string $table, bool $checkExist = false): bool
    {
        $sql = "DROP TABLE ";
        if ($checkExist) {
            if ($this->type === DatabaseEnum::SQLSRV) {
                $sql = "IF OBJECT_ID('{$table}', 'U') IS NULL " . $sql . $table;
            } else {
                $sql .= "IF EXISTS $table";
            }
        } else {
            $sql .= $table;
        }
        $result = $this->pdo->exec($sql);
        if ($result === false) {
            return false;
        }
        return true;
    }
    /**
     * dropIfExist
     *
     * @param  string $table
     * @return bool
     */
    public function dropIfExist(string $table): bool
    {
        return $this->drop($table, true);
    }
    /**
     * create
     *
     * @param  string $table
     * @param  array $columns
     * @param  array $primary
     * @param  array $unique
     * @param  string|null $attribute
     * @param  bool $checkExist
     * @return bool
     */
    public function create(string $table, array $columns, array $primary = [], array $unique = [], string|null $attribute = null, bool $checkExist = false): bool
    {
        $sql = "CREATE TABLE ";
        if ($checkExist) {
            if ($this->type === DatabaseEnum::SQLSRV) {
                $sql = "IF OBJECT_ID('{$table}', 'U') IS NULL " . $sql;
            } else {
                $sql .= "IF NOT EXISTS ";
            }
        }
        $sql .=  "$table(";
        foreach ($columns as $name => $type) {
            $sql .= $this->e($name) . " $type,";
        }
        if ($primary) {
            $sql .= "PRIMARY KEY (" . implode(',', array_map(fn ($attr) => $this->e($attr), $primary)) . '),';
        }
        if ($unique) {
            $sql .= "UNIQUE (" . implode(',', array_map(fn ($attr) => $this->e($attr), $unique)) . '),';
        }
        $sql = rtrim($sql, ',') . ')';
        if ($attribute) {
            $sql .= $attribute . ";";
        }
        $result = $this->pdo->exec($sql);
        if ($result === false) {
            return false;
        }
        return true;
    }
    /**
     * createIfNotExist
     *
     * @param  string $table
     * @param  array $columns
     * @param  array $primary
     * @param  array $unique
     * @param  string|null $attribute
     * @return bool
     */
    public function createIfNotExist(string $table, array $columns, array $primary = [], array $unique = [], string|null $attribute = null): bool
    {
        return $this->create($table, $columns, $primary, $unique, $attribute, true);
    }
    /**
     * getType
     *
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * e
     *
     * @param  string $attribute
     * @return string
     */
    public function e(string $attribute): string
    {
        $type = $this->getType();

        switch ($type) {
            case DatabaseEnum::MYSQL:
                return '`' . $attribute . '`';
                break;
            case DatabaseEnum::SQLITE:
            case DatabaseEnum::PGSQL:
                return '"' . $attribute . '"';
                break;
            case DatabaseEnum::SQLSRV:
                return '[' . $attribute . ']';
                break;
            default:
                return $attribute;
        }
    }
}
