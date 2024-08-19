<?php declare(strict_types=1);

namespace App\Model\Db;

use Faster\Component\Enums\DataTypeEnum;
use Faster\Db\Database;
use Faster\Model\DbModel;

/**
 * DokumentasiPembinaanModel
 */
class DokumentasiPembinaanModel extends DbModel
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

        $this->addProperty('permintaan_id', DataTypeEnum::INT);
        $this->addProperty('judul', DataTypeEnum::STRING);
        $this->addProperty('berita', DataTypeEnum::STRING);
        $this->addProperty('gambar', DataTypeEnum::STRING);
        $this->addProperty('tanggal', DataTypeEnum::STRING);
        $this->addProperty('is_active', DataTypeEnum::INT);
        $this->addProperty('create_by', DataTypeEnum::INT);
        $this->addProperty('update_by', DataTypeEnum::INT);
        $this->addProperty('approve_by', DataTypeEnum::INT);
        $this->addProperty('create_at', DataTypeEnum::INT);
        $this->addProperty('update_at', DataTypeEnum::INT);
        $this->addProperty('approve_at', DataTypeEnum::INT);

        parent::__construct($this->db);
    }
       
    /**
     * table
     *
     * @param  Database|null $db $db
     * @return string
     */
    public static function table(Database|null $db = null): string
    {
        return static::db($db)->getTable('dokumentasi_pembinaan');
    }
}