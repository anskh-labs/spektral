<?php declare(strict_types=1);

use Faster\Db\Migration;

class m0001_user extends Migration
{
    public function __construct()
    {
        $this->table = db()->getTable('user');
    }
    
    public function up(): bool
    { 
        $sql = "CREATE TABLE IF NOT EXISTS " . $this->table . "(
            `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
            `email` VARCHAR(100) NOT NULL UNIQUE,
            `password` VARCHAR(255) NULL,
            `nama` VARCHAR(100) NOT NULL,
            `nip` VARCHAR(20) NOT NULL,
            `jabatan` VARCHAR(255) NOT NULL,
            `instansi` VARCHAR(255) NOT NULL,
            `tingkat` VARCHAR(100) NOT NULL,
            `nomor_wa` VARCHAR(100) NOT NULL,
            `role` VARCHAR(255) NOT NULL,
            `token` VARCHAR(255) NULL,
            `reset_token` VARCHAR(255) NULL,
            `is_active` INT(11) NOT NULL default 0,
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
        $data = [
            [
                'email' => 'user@example.com',
                'password' => password_hash('user', PASSWORD_BCRYPT),
                'nama'=> 'User',
                'nip'=>'123456789012345678',
                'jabatan'=>'Fungsional Ahli Muda',
                'instansi'=>'Dinas XXX',
                'tingkat'=>'Provinsi',
                'nomor_wa'=>'08111111111111',
                'role'=>'user',
                'is_active' => 1,
                'create_at' => time()
            ]
        ];

        try
        {
            db()->insert($data, $this->table, true);
        }catch(Exception $e){
            echo($e->getMessage());
            return false;
        }
         
        return true;
    }
}