<?php

declare(strict_types=1);

namespace Faster\Component\Enums;

/**
 * DatabaseEnum
 * -----------
 * DatabaseEnum
 *
 * @author Khaerul Anas <khaerulanas@live.com>
 * @since 1.0.0
 * @package Faster\Component\Enums
 */
class DatabaseEnum extends BaseEnum
{
    public const MYSQL  = 'mysql';
    public const SQLITE = 'sqlite';
    public const PGSQL  = 'pgsql';
    public const SQLSRV = 'sqlsrv';
}

