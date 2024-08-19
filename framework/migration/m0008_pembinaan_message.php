<?php declare(strict_types=1);

use Faster\Db\Migration;

class m0008_pembinaan_message extends Migration
{
    public function __construct()
    {
        $this->table = db()->getTable('pembinaan_message');
    }
    
    public function up(): bool
    { 
        $sql = "CREATE TABLE IF NOT EXISTS " . $this->table . "(
            `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
            `pembinaan_id` INT(11) NOT NULL,
            `message_date` INT(11) NOT NULL DEFAULT UNIX_TIMESTAMP(),
            `user_id` INT(11) NULL,
            `message` text NOT NULL,
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