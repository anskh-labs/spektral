<?php declare(strict_types=1);

use Faster\Db\Migration;

class m0006_pembinaan_category extends Migration
{
    public function __construct()
    {
        $this->table = db()->getTable('pembinaan_category');
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
                'nama' => "Pertemuan virtual/daring",
                'create_at' => time()
            ],
            [
                'id' => 2,
                'nama' => "Pertemuan langsung dalam bentuk rapat",
                'create_at' => time()
            ],
            [
                'id' => 3,
                'nama' => "Pertemuan langsung dalam bentuk FGD",
                'create_at' => time()
            ],
            [
                'id' => 4,
                'nama' => "Pertemuan langsung dalam bentuk Musrenbang",
                'create_at' => time()
            ],
            [
                'id' => 5,
                'nama' => "Pertemuan langsung lainnya",
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