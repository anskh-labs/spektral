<?php declare(strict_types=1);

namespace App\Model\Db;

use Faster\Component\Enums\DataTypeEnum;
use Faster\Db\Database;
use Faster\Model\DbModel;
use PDO;

/**
 * UserModel
 */
class UserModel extends DbModel
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
        $this->table = static::table($this->db);

        $this->addProperty('email', DataTypeEnum::STRING);
        $this->addProperty('password', DataTypeEnum::STRING);
        $this->addProperty('nama', DataTypeEnum::STRING);
        $this->addProperty('nip', DataTypeEnum::STRING);
        $this->addProperty('jabatan', DataTypeEnum::STRING);
        $this->addProperty('instansi', DataTypeEnum::STRING);
        $this->addProperty('tingkat', DataTypeEnum::INT);
        $this->addProperty('nomor_wa', DataTypeEnum::STRING);
        $this->addProperty('role', DataTypeEnum::STRING);
        $this->addProperty('token', DataTypeEnum::STRING);
        $this->addProperty('reset_token', DataTypeEnum::STRING);
        $this->addProperty('is_active', DataTypeEnum::INT);
        $this->addProperty('create_at', DataTypeEnum::INT);
        $this->addProperty('update_at', DataTypeEnum::INT);
        $this->addProperty('update_by', DataTypeEnum::INT);
        
        parent::__construct($this->db);
    }    
    /**
     * table
     *
     * @param  Database|null $db
     * @return string
     */
    public static function table(Database|null $db = null): string
    {
        return static::db($db)->getTable('user');
    }
    
    /**
     * whereRole
     *
     * @param  string $role
     * @return array
     */
    public static function whereRole(string $role): array
    {
        return static::findColumn('`email`', "`role` LIKE '%{$role}%'");
    }
    public static function rekapbyKategori(Database|null $db = null):array
    {
        $table = static::table($db);
        $stm = static::db($db)->query("SELECT P.`kategori`, SUM(P.`aktif`) AS `aktif`,SUM(P.`tidak_aktif`) AS `tidak_aktif` FROM(SELECT CASE WHEN LOCATE('@bps.go.id', `email`)>0 THEN 'Internal' ELSE 'Eksternal' END AS `kategori`, CASE `is_active` WHEN 1 THEN 1 ELSE 0 END AS `aktif`, CASE `is_active` WHEN 0 THEN 1 ELSE 0 END AS `tidak_aktif` FROM $table) P GROUP BY P.`kategori`;");
        return $stm->fetchAll(PDO::FETCH_ASSOC);
    }
}