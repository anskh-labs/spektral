<?php

declare(strict_types=1);

namespace Faster\Db;

use Exception;
use Faster\Component\Enums\DatabaseEnum;

/**
 * Migration
 * -----------
 * Class to handle migration file
 *
 * @author Khaerul Anas <khaerulanas@live.com>
 * @since 1.0.0
 * @package Faster\Db
 */
abstract class Migration
{
    protected Database $db;
    protected string $table;

    /**
     * up
     *
     * @return bool
     */
    abstract public function up(): bool;
    /**
     * seed
     *
     * @return bool
     */
    abstract public function seed(): bool;
    /**
     * down
     *
     * @return bool
     */
    public function down(): bool
    {
        try {
            $this->db->dropIfExist($this->table);
            return true;
        } catch (Exception $e) {
            $this->log($e->getMessage());
            return false;
        }
    }
    /**
     * log
     *
     * @param  string $message
     * @return void
     */
    protected function log(string $message)
    {
        echo '[' . date('Y-m-d H:i:s') . '] - ' . $message . PHP_EOL;
    }
}
