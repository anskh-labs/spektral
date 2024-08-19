<?php declare(strict_types=1);

use Faster\Db\Migration;

class m0004_modul_category extends Migration
{
    public function __construct()
    {
        $this->table = db()->getTable('modul_category');
    }
    
    public function up(): bool
    { 
        $sql = "CREATE TABLE IF NOT EXISTS " . $this->table . "(
            `id` INT(11) UNSIGNED NOT NULL,
            `nama` VARCHAR(255) NOT NULL,
            `deskripsi` VARCHAR(255) NOT NULL,
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
                'nama' => "Umum dan Peraturan",
                'deskripsi' => 'Modul pembinaan statistik berkaitan dengan metodologi sensus dan survei, peraturan terkait pembinaan statistik, metadata statistik, maupun rekomendasi statistik',
                'create_at' => time()
            ],
            [
                'id' => 2,
                'nama' => "Sosial dan Kependudukan",
                'deskripsi' => 'Modul pembinaan statistik berkaitan dengan statistik ketenagakerjaan, kependudukan, pendidikan, kemiskinan dan beberapa statistik berkaitan dengan demografi dan sosial lainnya',
                'create_at' => time()
            ],
            [
                'id' => 3,
                'nama' => "Pertanian dan Pertambangan",
                'deskripsi' => 'Modul pembinaan statistik berkaitan dengan statistik pertanian tanaman pangan, hortikultura, peternakan, perkebunan, perikanan, kehutanan, sumberdaya/energi, dan pertambangan',
                'create_at' => time()
            ],
            [
                'id' => 4,
                'nama' => "Ekonomi dan Perdagangan",
                'deskripsi' => 'Modul pembinaan statistik berkaitan dengan statistik harga, perdagangan, ekspor, impor, pertumbuhan ekonomi, PDRB, transportasi, industri, dan statistik distribusi lainnya',
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