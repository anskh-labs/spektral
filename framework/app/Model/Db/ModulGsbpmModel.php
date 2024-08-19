<?php declare(strict_types=1);

namespace App\Model\Db;

use Faster\Component\Enums\DataTypeEnum;
use Faster\Db\Database;
use Faster\Model\DbModel;

/**
 * ModulGsbpmModel
 */
class ModulGsbpmModel extends DbModel
{    
    /**
     * __construct
     *
     * @return void
     */    
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
        $this->autoIncrement = false;

        $this->addProperty('id', DataTypeEnum::INT);
        $this->addProperty('tahapan', DataTypeEnum::STRING);
        $this->addProperty('isi', DataTypeEnum::STRING);
        $this->addProperty('gambar', DataTypeEnum::STRING);
        $this->addProperty('link', DataTypeEnum::STRING);
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
        return static::db($db)->getTable('modul_gsbpm');
    }
}