<?php declare(strict_types=1);

namespace App\Model\Db;

use Faster\Db\Database;
use Faster\Model\DbJoinModel;

/**
 * TestimoniJoinUserModel
 */
class TestimoniJoinUserModel extends DbJoinModel
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
     * @return string
     */
    public static function joinTable(Database|null $db = null): string
    {
        $db = static::db($db);
        return $db->getTable('testimoni') . ' AS a LEFT JOIN ' . $db->getTable('user') . ' AS b ON a.create_by=b.id';
    }    
    /**
     * joinColumn
     *
     * @return string
     */
    public static function joinColumn(): string
    {
        return 'a.id,a.pesan,a.rating,a.is_active,a.create_at,a.update_at,b.nama,b.instansi,b.jabatan';
    }
}