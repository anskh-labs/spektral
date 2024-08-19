<?php

declare(strict_types=1);

namespace Faster\Helper;

use Faster\Db\Database;

/**
 * Db
 * -----------
 * Db
 *
 * @author Khaerul Anas <khaerulanas@live.com>
 * @since 1.0.0
 * @package Faster\Helper
 */
class Db
{
    const DSN = 'dsn';
    const TABLE_PREFIX = 'table_prefix';
    const USERNAME = 'username';
    const PASSWORD = 'password';
    const PDO_OPTIONS = 'pdo_options';

    /**
     * defaultConnection
     *
     * @return string
     */
    public static function defaultConnection(): string
    {
        return config('database.default');
    }    
    /**
     * get
     *
     * @param  string $connection
     * @return Database
     */
    public static function get(string $connection): Database
    {
        return Database::getInstance($connection);
    }    
    /**
     * options
     *
     * @param  string $name
     * @return array
     */
    public static function options(string $name): array
    {
        return config('database.connections.' . $name);
    }
}
