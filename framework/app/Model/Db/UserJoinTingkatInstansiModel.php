<?php declare(strict_types=1);

namespace App\Model\Db;

use Faster\Db\Database;
use Faster\Model\DbJoinModel;

/**
 * UserJoinTingkatInstansiModel
 */
class UserJoinTingkatInstansiModel extends DbJoinModel
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
        return $db->getTable('user') . ' AS a LEFT JOIN ' . $db->getTable('tingkat_instansi') . ' AS b ON a.tingkat=b.id';
    }    
    /**
     * joinColumn
     *
     * @return string
     */
    public static function joinColumn(): string
    {
        return 'a.id, a.email, a.password, a.nama, a.nip, a.jabatan, a.instansi, a.tingkat, a.nomor_wa, a.role, a.token, a.reset_token, a.is_active, a.create_at, a.update_at, a.update_by, b.nama as tingkat_instansi';
    }
}