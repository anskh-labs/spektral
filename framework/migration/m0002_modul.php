<?php declare(strict_types=1);

use Faster\Db\Migration;

class m0002_modul extends Migration
{
    public function __construct()
    {
        $this->table = db()->getTable('modul');
    }
    
    public function up(): bool
    { 
        $sql = "CREATE TABLE IF NOT EXISTS " . $this->table . "(
            `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
            `nama` VARCHAR(255) NOT NULL,
            `deskripsi` VARCHAR(255) NOT NULL,
            `jenis` VARCHAR(20) NOT NULL DEFAULT 'pdf',
            `kategori` INT(4) NOT NULL,
            `link` VARCHAR(255) NOT NULL,
            'create_by' INT(11) NOT NULL,
            'update_by' INT(11) NULL,
            `create_at` INT(11) NOT NULL DEFAULT UNIX_TIMESTAMP(),
            `update_at` INT(11) NULL,
            PRIMARY KEY (`id`)
        )ENGINE=InnoDB DEFAULT CHARACTER SET=utf8;";

        try
        {
            db()->exec($sql);
        }catch(Exception $e){
            echo($e->getMessage());
            return false;
        }
         
        return true;
    }

    public function seed(): bool
    {
        return false;
    }
}