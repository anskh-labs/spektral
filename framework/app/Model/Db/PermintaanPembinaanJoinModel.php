<?php declare(strict_types=1);

namespace App\Model\Db;

use Faster\Db\Database;
use Faster\Model\DbJoinModel;

/**
 * PermintaanPembinaanJoinModel
 */
class PermintaanPembinaanJoinModel extends DbJoinModel
{    
    /**
     * __construct
     *
     * @return void
     */
    public function __construct(Database|null $db = null)
    {
        $this->db = static::db($db);
        $this->joinTable =  static::joinTable($this->db);

        parent::__construct($this->db);
    }
    
    /**
     * table
     *
     * @return string
     */
    public static function joinTable(Database|null $db = null): string
    {
        $db = static::db($db);
        return $db->getTable('permintaan') . ' AS a LEFT JOIN ' . $db->getTable('model_pembinaan') . ' AS b ON a.model_pembinaan=b.id LEFT JOIN ' . $db->getTable('status_permintaan') . ' AS c ON a.status=c.id LEFT JOIN ' . $db->getTable('user') . ' AS d ON a.create_by=d.id LEFT JOIN ' . $db->getTable('tingkat_instansi') . ' AS e ON d.tingkat=e.id';
    }    
    /**
     * joinColumn
     *
     * @return string
     */
    public static function joinColumn(): string
    {
        return 'a.id,a.produsen_data,a.deskripsi,a.model_pembinaan,a.tanggal,a.waktu,a.lokasi,a.surat,a.email_pic,a.nama_pic,a.hp_pic,a.status,a.create_by,a.create_at,b.nama as nama_model_pembinaan,c.nama as status_permintaan,d.nama as nama_pendaftar,d.email as email_pendaftar,d.nomor_wa as hp_pendaftar,d.nip,d.instansi,d.tingkat,e.nama as tingkat_instansi';
    }
}