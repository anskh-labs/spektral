<?php declare(strict_types=1);

use Faster\Db\Migration;

class m0005_pembinaan extends Migration
{
    public function __construct()
    {
        $this->table = db()->getTable('pembinaan');
    }
    
    public function up(): bool
    { 
        $sql = "CREATE TABLE IF NOT EXISTS " . $this->table . "(
            `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
            `produsen_data` INT(4) NOT NULL,
            `deskripsi` VARCHAR(255) NOT NULL,
            `jenis` INT(11) NOT NULL,
            `tanggal` DATE NOT NULL,
            `waktu` TIME NOT NULL,
            `lokasi` VARCHAR(255) NOT NULL,
            `surat` VARCHAR(255) NOT NULL,
            `email_pic` VARCHAR(255) NOT NULL,
            `nama_pic` VARCHAR(100) NOT NULL,
            `nomor_hp_pic` VARCHAR(100) NOT NULL,
            `status` INT(11) NOT NULL,
            `create_by` INT(11) NOT NULL,
            `update_by` INT(11) NULL,
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