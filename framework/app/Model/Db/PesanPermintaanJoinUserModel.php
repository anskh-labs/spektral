<?php declare(strict_types=1);

namespace App\Model\Db;

use Faster\Db\Database;
use Faster\Model\DbJoinModel;

/**
 * PesanPermintaanJoinUserModel
 */
class PesanPermintaanJoinUserModel extends DbJoinModel
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
        return $db->getTable('pesan_permintaan') . ' AS a LEFT JOIN ' . $db->getTable('user') . ' AS b ON a.user_id=b.id';
    }    
    /**
     * joinColumn
     *
     * @return string
     */
    public static function joinColumn(): string
    {
        return 'a.id,a.permintaan_id,a.waktu,a.user_id,a.pesan,b.nama,b.email,b.role';
    }
}