<?php declare(strict_types=1);

namespace App\Model\Db;

use Faster\Component\Enums\DataTypeEnum;
use Faster\Db\Database;
use Faster\Model\DbModel;
use PDO;

/**
 * ModulPembinaanModel
 */
class ModulPembinaanModel extends DbModel
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

        $this->addProperty('nama', DataTypeEnum::STRING);
        $this->addProperty('deskripsi', DataTypeEnum::STRING);
        $this->addProperty('kategori', DataTypeEnum::INT);
        $this->addProperty('link', DataTypeEnum::STRING);
        $this->addProperty('is_active', DataTypeEnum::INT);
        $this->addProperty('create_by', DataTypeEnum::INT);
        $this->addProperty('update_by', DataTypeEnum::INT);
        $this->addProperty('create_at', DataTypeEnum::INT);
        $this->addProperty('update_at', DataTypeEnum::INT);
        $this->addProperty('approve_by', DataTypeEnum::INT);
        $this->addProperty('approve_at', DataTypeEnum::INT);

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
        return static::db($db)->getTable('modul_pembinaan');
    }
    public static function rekapByKategori(Database|null $db = null): array
    {
        $stm = static::db($db)->query("SELECT a.kategori,b.nama,SUM(CASE WHEN a.is_active=1 THEN 1 ELSE 0 END) AS `aktif`,SUM(CASE WHEN a.is_active=0 THEN 1 ELSE 0 END) AS `tidak_aktif` FROM dbo_modul_pembinaan a left join dbo_kategori_modul_pembinaan b on a.kategori=b.id GROUP BY a.kategori ORDER BY a.kategori;");
        return $stm->fetchAll(PDO::FETCH_ASSOC);
    }
}