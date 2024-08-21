<?php declare(strict_types=1);

namespace App\Model\Db;

use Faster\Component\Enums\DataTypeEnum;
use Faster\Db\Database;
use Faster\Model\DbModel;
use PDO;

/**
 * PermintaanPembinaanModel
 */
class PermintaanPembinaanModel extends DbModel
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

        $this->addProperty('produsen_data', DataTypeEnum::INT);
        $this->addProperty('deskripsi', DataTypeEnum::STRING);
        $this->addProperty('model_pembinaan', DataTypeEnum::INT);
        $this->addProperty('tanggal', DataTypeEnum::STRING);
        $this->addProperty('waktu', DataTypeEnum::STRING);
        $this->addProperty('lokasi', DataTypeEnum::STRING);
        $this->addProperty('surat', DataTypeEnum::STRING);
        $this->addProperty('email_pic', DataTypeEnum::STRING);
        $this->addProperty('nama_pic', DataTypeEnum::STRING);
        $this->addProperty('hp_pic', DataTypeEnum::STRING);
        $this->addProperty('status', DataTypeEnum::INT);
        $this->addProperty('create_by', DataTypeEnum::INT);
        $this->addProperty('update_by', DataTypeEnum::INT);
        $this->addProperty('create_at', DataTypeEnum::INT);
        $this->addProperty('update_at', DataTypeEnum::INT);

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
        return static::db($db)->getTable('permintaan');
    }
    public static function rekapByStatus(Database|null $db = null): array
    {
        $stm = static::db($db)->query("SELECT P.bln,SUM(CASE WHEN P.id=1 THEN 1 ELSE 0 END) AS `dibuka`,SUM(CASE WHEN P.id=2 THEN 1 ELSE 0 END) AS `diproses`,SUM(CASE WHEN P.id=3 THEN 1 ELSE 0 END) AS `menunggu`,SUM(CASE WHEN P.id=4 THEN 1 ELSE 0 END) AS `disetujui`,SUM(CASE WHEN P.id=5 THEN 1 ELSE 0 END) AS `ditutup` FROM(SELECT MONTH(FROM_UNIXTIME(a.create_at)) as bln,b.id  FROM `dbo_permintaan` a left join `dbo_status_permintaan` b on a.status=b.id) P GROUP BY P.bln ORDER BY P.bln;");
        return $stm->fetchAll(PDO::FETCH_ASSOC);
    }
}