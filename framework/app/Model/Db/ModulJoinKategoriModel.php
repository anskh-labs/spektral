<?php declare(strict_types=1);

namespace App\Model\Db;

use Faster\Db\Database;
use Faster\Model\DbJoinModel;

/**
 * ModulJoinKategoriModel
 */
class ModulJoinKategoriModel extends DbJoinModel
{        
    /**
     * __construct
     *
     * @param  Database|null $db
     * @return void
     */
    public function __construct(Database|null $db = null)
    {
        $this->db = static::db($db);
        $this->joinTable =  static::joinTable($this->db);

        parent::__construct($this->db);
    }
    /**
     * joinTable
     *
     * @param  Database|null $db
     * @return string
     */
    public static function joinTable(Database|null $db = null): string
    {
        $db = static::db($db);
        return $db->getTable('modul') . ' AS a LEFT JOIN ' . $db->getTable('modul_category') . ' AS b ON a.kategori=b.id';
    }    
    /**
     * joinColumn
     *
     * @return string
     */
    public static function joinColumn(): string
    {
        return 'a.id,a.nama,a.deskripsi,a.jenis,a.link,a.kategori as idkategori,b.nama as kategori';
    }
}