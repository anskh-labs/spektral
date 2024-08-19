<?php declare(strict_types=1);

use Faster\Db\Migration;

class m0007_status_permintaan extends Migration
{
    public function __construct()
    {
        $this->table = db()->getTable('status_permintaan');
    }
    
    public function up(): bool
    { 
        $sql = "CREATE TABLE IF NOT EXISTS " . $this->table . "(
            `id` INT(11) UNSIGNED NOT NULL,
            `nama` VARCHAR(255) NOT NULL,
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
                'id' => 1,
                'nama' => "Dibuka",
                'create_at' => time()
            ],
            [
                'id' => 2,
                'nama' => "Diproses",
                'create_at' => time()
            ],
            [
                'id' => 3,
                'nama' => "Menunggu balasan",
                'create_at' => time()
            ],
            [
                'id' => 4,
                'nama' => "Disetujui",
                'create_at' => time()
            ],
            [
                'id' => 5,
                'nama' => "Ditutup",
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