<?php declare(strict_types=1);

namespace App\Model\Db;

use Faster\Component\Enums\DataTypeEnum;
use Faster\Db\Database;
use Faster\Model\DbModel;

/**
 * PesanPermintaanModel
 */
class PesanPermintaanModel extends DbModel
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
        $this->addProperty('waktu', DataTypeEnum::INT);
        $this->addProperty('user_id', DataTypeEnum::INT);
        $this->addProperty('pesan', DataTypeEnum::STRING);

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
        return static::db($db)->getTable('pesan_permintaan');
    }
}