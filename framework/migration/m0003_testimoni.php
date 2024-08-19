<?php declare(strict_types=1);

use Faster\Db\Migration;

class m0003_testimoni extends Migration
{
    public function __construct()
    {
        $this->table = db()->getTable('testimoni');
    }
    
    public function up(): bool
    { 
        $sql = "CREATE TABLE IF NOT EXISTS " . $this->table . "(
            `id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
            `userid` INT(11) UNSIGNED NOT NULL,
            `pesan` VARCHAR(255) NOT NULL,
            `rating` INT(11) NOT NULL DEFAULT 5,
            `is_active` INT(4) NOT NULL DEFAULT 1,
            `create_at` INT(11) NOT NULL DEFAULT UNIX_TIMESTAMP(),
            `update_at` INT(11) NULL,
            PRIMARY KEY (`id`),
            FOREIGN KEY (`userid`) REFERENCES " . db()->getTable('user') . "(`id`)
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
                'userid' => 1,
                'pesan' => "Our members are so impressed. It's intuitive. It's clean. It's distraction free. If you're building a community.",
                'rating'=> 5,
                'create_at' => time()
            ],
            [
                'userid' => 1,
                'pesan' => "Spektral is exactly what I've been looking for.",
                'rating'=> 4,
                'create_at' => time()
            ],
            [
                'userid' => 1,
                'pesan' => "Spektral makes me more productive and gets the job done in a fraction of the time. I'm glad I found spektral.",
                'rating'=> 5,
                'create_at' => time()
            ],
            [
                'userid' => 1,
                'pesan' => "I can't say enough about Spektral. Spektral has really helped our business.",
                'rating'=> 4,
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