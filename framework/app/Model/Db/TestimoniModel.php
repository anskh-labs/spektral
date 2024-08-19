<?php declare(strict_types=1);

namespace App\Model\Db;

use Faster\Component\Enums\DataTypeEnum;
use Faster\Db\Database;
use Faster\Model\DbModel;

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
}