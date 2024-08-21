<?php declare(strict_types=1);

namespace App\Model\Db;

use Faster\Component\Enums\DataTypeEnum;
use Faster\Db\Database;
use Faster\Model\DbModel;
use PDO;

/**
 * TestimoniModel
 */
class TestimoniModel extends DbModel
{    
    /**
     * __construct
     *
     * @return void
     */
    public function __construct(Database|null $db = null)
    {
        $this->db = static::db($db);
        $this->table = static::table($this->db);

        $this->addProperty('pesan', DataTypeEnum::STRING);
        $this->addProperty('rating', DataTypeEnum::INT);
        $this->addProperty('is_active', DataTypeEnum::INT);
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
        return static::db($db)->getTable('testimoni');
    }
    public static function rekapAktif(Database|null $db = null):array
    {
        $table = static::table($db);
        $stm = static::db($db)->query("SELECT COUNT(CASE WHEN P.`is_active`=1 THEN 1 ELSE NULL END) AS `aktif`,COUNT(CASE WHEN P.`is_active`=0 THEN 1 ELSE NULL END) AS `tidak_aktif` FROM  $table P GROUP BY P.is_active;");
        return $stm->fetch(PDO::FETCH_ASSOC);
    }
}