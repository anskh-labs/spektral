<?php

declare(strict_types=1);

namespace Faster\Model;

use Faster\Component\Enums\DataTypeEnum;
use Faster\Db\Database;
use Faster\Html\Pagination;
use PDO;

/**
 * DbModel
 * -----------
 * DbModel
 *
 * @author Khaerul Anas <khaerulanas@live.com>
 * @since 1.0.0
 * @package Faster\Model
 */
abstract class DbModel extends Model
{
    const ID = 'id';

    protected Database $db;
    protected string $table;
    protected bool $autoIncrement = true;
    protected string $primaryKey = 'id';
    protected array $fields = [];
    protected bool $editMode = false;

    /**
     * __construct
     *
     * @param  Database|null $db
     * @return void
     */
    public function __construct(Database|null $db = null)
    {
        $this->db = $db ?? db();
        if (!isset($this->table)) {
            $arr = explode('\\', static::class);
            $this->table = $this->db->getTable(strtolower(end($arr)));
        }
        if (empty($this->fields)) {
            $this->generateFields();
        }
    }

    /**
     * getTable
     *
     * @return string
     */
    public function getTable(): string
    {
        return $this->table;
    }

    /**
     * getPrimaryKey
     *
     * @return string
     */
    public function getPrimaryKey(): string
    {
        return $this->primaryKey;
    }

    /**
     * getFields
     *
     * @return array
     */
    public function getFields(): array
    {
        return $this->fields;
    }
    /**
     * addProperty
     *
     * @param  string $property
     * @param  string $type
     * @param  mixed $defaultValue
     * @return void
     */
    public function addProperty(string $property, string $type = DataTypeEnum::STRING, $defaultValue = null): void
    {
        $this->fields[] = $property;
        $this->types[$property] = $type;
        $this->storage[$property] = $defaultValue;
    }
    /**
     * load
     *
     * @param  string|int  $pk
     * @return bool
     */
    public function load($pk): bool
    {
        $data = $this->db->select($this->table, '*', [$this->primaryKey . "=" => $pk], 1);

        if ($data) {
            foreach ($data as $row) {
                $this->fill($row);
            }
            return true;
        }

        return false;
    }
    /**
     * save
     *
     * @param  bool $isUpdate
     * @return bool
     */
    public function save(bool $isUpdate = false): bool
    {
        $data = [];
        foreach ($this->fields as $field) {
            $data[$field] = $this->{$field} ?? null;
        }
        if ($isUpdate) {
            $pk = $this->primaryKey;
            unset($data[$pk]);
            return $this->db->update($data, $this->table, [$pk . '=' => $this->{$pk}]) >= 0 ? true : false;
        } else {
            return $this->db->insert($data, $this->table) > 0 ? true : false;
        }
    }
    /**
     * getRecordCount
     *
     * @param  array|string|null $where
     * @return int
     */
    public function getRecordCount(array|string|null $where = null): int
    {
        return $this->db->getRecordCount($this->table, $where);
    }
    /**
     * isExists
     *
     * @param  array|string|null $where
     * @return bool
     */
    public function isExists(array|string|null $where = null): bool
    {
        return $this->db->recordExists($this->table, $where);
    }
    /**
     * generateFields
     *
     * @return void
     */
    protected function generateFields(): void
    {
        $stmt = $this->db->query("SELECT * FROM " . $this->db->getTable($this->table) . " LIMIT 0;");
        $columnCount = $stmt->columnCount();
        for ($i = 0; $i < $columnCount; $i++) {
            $col = $stmt->getColumnMeta($i);
            $this->fields[] = $col['name'];
            $type =  DataTypeEnum::hasValue($col['native_type']) ? $col['native_type'] : DataTypeEnum::defaultType();
            $this->addProperty($col['name'], $type);
        }

        if ($this->autoIncrement) {
            unset($this->fields[$this->primaryKey]);
            unset($this->types[$this->primaryKey]);
            unset($this->storage[$this->primaryKey]);
        }
    }
    /**
     * table
     *
     * @param  Database|null $db
     * @return string
     */
    public static function table(Database|null $db = null): string
    {
        $arr = explode('\\', static::class);
        return static::db($db)->getTable(strtolower(end($arr)));
    }
    /**
     * primaryKey
     *
     * @return string
     */
    public static function primaryKey(): string
    {
        return static::ID;
    }
    /**
     * Get db
     *
     * @param  Database|null $db
     * @return Database
     */
    public static function db(Database|null $db = null): Database
    {
        return $db ?? db();
    }
    /**
     * create
     *
     * @param  array $data
     * @param  Database|null $db
     * @return int
     */
    public static function create(array $data, Database|null $db = null): int
    {
        return static::db($db)->insert($data, static::table());
    }
    /**
     * update
     *
     * @param  array $data
     * @param  array|string|null  $where
     * @param  Database|null $db
     * @return int
     */
    public static function update(array $data, array|string|null $where = null, Database|null $db = null): int
    {
        return static::db($db)->update($data, static::table(), $where);
    }
    /**
     * delete
     *
     * @param  array|string|null  $where
     * @param  Database|null $db
     * @return int
     */
    public static function delete(array|string|null $where = null, Database|null $db = null): int
    {
        return static::db($db)->delete(static::table(), $where);
    }
    /**
     * all
     *
     * @param  string $column
     * @param  string|null $orderby
     * @param  Database|null $db
     * @return array
     */
    public static function all(string $column = '*', string|null $orderby = null, Database|null $db = null): array
    {
        return static::db($db)->select(static::table(), $column, null, 0, -1, $orderby);
    }
    /**
     * allColumn
     *
     * @param  string $column
     * @param  string|null $orderby
     * @param  Database|null $db $db
     * @return array
     */
    public static function allColumn(string $column, string|null $orderby = null, Database|null $db = null): array
    {
        return static::db($db)->select(static::table(), $column, null, 0, -1, $orderby, PDO::FETCH_COLUMN);
    }
    /**
     * row
     *
     * @param  string $column
     * @param  array|string|null  $where
     * @param  Database|null $db
     * @return array
     */
    public static function row(string $column = '*', array|string|null $where = null, Database|null $db = null): array
    {
        return static::db($db)->getRow(static::table(), $column, $where);
    }
    /**
     * recordCount
     *
     * @param  array|string|null $where
     * @param  Database|null $db
     * @return int
     */
    public static function recordCount(array|string|null $where = null, Database|null $db = null): int
    {
        return static::db($db)->getRecordCount(static::table(), $where);
    }
    /**
     * find
     *
     * @param  array|string|null $where
     * @param  string $column
     * @param  int $limit
     * @param  string|null $orderby
     * @param  Database|null $db
     * @return array
     */
    public static function find(array|string|null $where = null, string $column = '*', int $limit = 0, int $offset = -1, string|null $orderby = null, Database|null $db = null): array
    {
        return static::db($db)->select(static::table(), $column, $where, $limit, $offset, $orderby);
    }
    /**
     * paginate
     *
     * @param  array|string|null $where
     * @param  string $column
     * @param  int|null $perpage
     * @param  string|null $orderby
     * @param  Database|null $db
     * @return DbRecordSet
     */
    public static function paginate(array|string|null $where = null, string $column = '*', int|null $perpage = null, string|null $orderby = null, Database|null $db = null): DbRecordSet
    {
        $pager = new Pagination(static::recordCount($where), $perpage);
        $rows = static::db($db)->select(static::table(), $column, $where, $pager->perPage(), $pager->offset(), $orderby);
        return new DbRecordSet($rows, $pager);
    }
    /**
     * findColumn
     *
     * @param  string $column
     * @param  array|string|null  $where
     * @param  int $limit
     * @param  int $offset
     * @param  string|null $orderby
     * @param  Database|null $db
     * @return array
     */
    public static function findColumn(string $column, array|string|null $where = null, int $limit = 0, int $offset = -1, string|null $orderby = null, Database|null $db = null): array
    {
        return static::db($db)->select(static::table(), $column, $where, $limit, $offset, $orderby, PDO::FETCH_COLUMN);
    }
    /**
     * column
     *
     * @param  string $column
     * @param  array|string|null  $where
     * @param  Database|null $db
     * @return mixed
     */
    public static function column(string $column, array|string|null $where = null, Database|null $db = null): mixed
    {
        return static::db($db)->getColumn(static::table(), $column, $where);
    }
    /**
     * exists
     *
     * @param  array|string|null $where
     * @param  Database|null $db
     * @return bool
     */
    public static function exists(array|string|null $where = null, Database|null $db = null): bool
    {
        return static::db($db)->recordExists(static::table(), $where);
    }
}
