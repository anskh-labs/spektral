<?php

declare(strict_types=1);

namespace Faster\Model;

use Faster\Db\Database;
use Faster\Html\Pagination;
use Exception;
use PDO;

/**
 * DbJoinModel
 * -----------
 * DbJoinModel
 *
 * @author Khaerul Anas <khaerulanas@live.com>
 * @since 1.0.0
 * @package Faster\Model
 */
abstract class DbJoinModel extends Model
{
    protected Database $db;
    protected string $joinTable;

    /**
     * __construct
     *
     * @param  Database|null $db
     * @return void
     */
    public function __construct(Database|null $db = null)
    {
        $this->db = $db ?? db();
    }
    /**
     * getJoinTable
     *
     * @return string
     */
    public function getJoinTable(): string
    {
        if (!$this->joinTable) {
            throw new Exception('Table property must be set.');
        }
        return $this->joinTable;
    }
    /**
     * getRecordCount
     *
     * @param  array|string|null $where
     * @return int
     */
    public function getRecordCount(array|string|null $where = null): int
    {
        return $this->db->getRecordCount($this->joinTable, $where);
    }
    /**
     * isExists
     *
     * @param  array|string|null  $where
     * @return bool
     */
    public function isExists(array|string|null $where = null): bool
    {
        return $this->db->recordExists($this->joinTable, $where);
    }   
    /**
     * joinTable
     *
     * @param  Database|null $db
     * @return string
     */
    public static function joinTable(Database|null $db = null): string
    {
        throw new Exception('This method must be implemented.');
    }    
    /**
     * joinColumn
     *
     * @return string
     */
    public static function joinColumn(): string
    {
        throw new Exception('This method must be implemented.');
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
     * all
     *
     * @param  string $joinColumn
     * @param  string|null $orderby
     * @param  Database|null $db
     * @return array
     */
    public static function all(string $joinColumn = '*', string|null $orderby = null, Database|null $db = null): array
    {
        if($joinColumn === '*'){
            $joinColumn = static::joinColumn();
        }
        return static::db($db)->select(static::joinTable(), $joinColumn, null, 0, -1, $orderby);
    }
    /**
     * allJoinColumn
     *
     * @param  string $joinColumn
     * @param  string|null $orderby
     * @param  Database|null $db
     * @return array
     */
    public static function allJoinColumn(string $joinColumn, string|null $orderby = null, Database|null $db = null): array
    {
        return static::db($db)->select(static::joinTable(), $joinColumn, null, 0, -1, $orderby, PDO::FETCH_COLUMN);
    }
    /**
     * row
     *
     * @param  string $joinColumn
     * @param  array|string|null $where
     * @param  Database|null $db
     * @return array
     */
    public static function row(string $joinColumn = '*', array|string|null $where = null, Database|null $db = null): array
    {
        if($joinColumn === '*'){
            $joinColumn = static::joinColumn();
        }
        return static::db($db)->getRow(static::joinTable(), $joinColumn, $where);
    }
    /**
     * recordCount
     *
     * @param  array|string|null  $where
     * @param  Database|null $db
     * @return int
     */
    public static function recordCount(array|string|null $where = null, Database|null $db = null): int
    {
        return static::db($db)->getRecordCount(static::joinTable(), $where);
    }
    /**
     * find
     *
     * @param  array|string|null  $where
     * @param  string $joinColumn
     * @param  int $limit
     * @param  string|null $orderby
     * @param  Database|null $db
     * @return array
     */
    public static function find(array|string|null $where = null, string $joinColumn = '*', int $limit = 0, int $offset = -1, string|null $orderby = null, Database|null $db = null): array
    {
        if($joinColumn === '*'){
            $joinColumn = static::joinColumn();
        }
        return static::db($db)->select(static::joinTable(), $joinColumn, $where, $limit, $offset, $orderby);
    }
    /**
     * paginate
     *
     * @param  array|string|null  $where
     * @param  string $joinColumn
     * @param  int|null $perpage
     * @param  string|null $orderby
     * @param  Database|null $db
     * @return DbRecordSet
     */
    public static function paginate(array|string|null $where = null, string $joinColumn = '*', int|null $perpage = null, string|null $orderby = null, Database|null $db=null): DbRecordSet
    {
        $pager = new Pagination(static::recordCount($where), $perpage);
        if($joinColumn === '*'){
            $joinColumn = static::joinColumn();
        }
        $rows = static::db($db)->select(static::joinTable(), $joinColumn, $where, $pager->perPage(), $pager->offset(), $orderby);
        return new DbRecordSet($rows, $pager);
    }
    /**
     * findJoinColumn
     *
     * @param  array|string|null $where
     * @param  string $joinColumn
     * @param  int $limit
     * @param  int $offset
     * @param  string|null $orderby
     * @param  Database|null $db
     * @return array
     */
    public static function findJoinColumn(array|string|null $where = null, string $joinColumn = '*', int $limit = 0, int $offset = -1, string|null $orderby = null, Database|null $db = null): array
    {
        if($joinColumn === '*'){
            $joinColumn = static::joinColumn();
        }
        return static::db($db)->select(static::joinTable(), $joinColumn, $where, $limit, $offset, $orderby, PDO::FETCH_COLUMN);
    }
    /**
     * exists
     *
     * @param  array|string|null  $where
     * @param  Database|null $db
     * @return bool
     */
    public static function exists(array|string|null $where = null, Database|null $db = null): bool
    {
        return static::db($db)->recordExists(static::joinTable(), $where);
    }
}
