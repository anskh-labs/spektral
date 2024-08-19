<?php

declare(strict_types=1);

use Faster\Helper\Db;

return [
    'default' => $_ENV['DB_CONNECTION'] ?? 'sqlite',
    'connections' =>[
        'mysql' => [
            Db::TABLE_PREFIX => 'dbo_',
            Db::DSN => 'mysql:host=localhost;port=3306;dbname=spektral;',
            Db::USERNAME => 'root',
            Db::PASSWORD => '',
            Db::PDO_OPTIONS => [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]
        ],
        'pgsql' => [
            Db::TABLE_PREFIX => 'dbo_',
            Db::DSN => 'pgsql:host=localhost;port=5432;dbname=spektral;',
            Db::USERNAME => 'postgres',
            DB::PASSWORD => 'postgres',
            Db::PDO_OPTIONS => [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]
        ],
        'sqlsrv' => [
            Db::TABLE_PREFIX => 'dbo_',
            Db::DSN => 'sqlsrv:Server=.\\sqlexpress;Database=spektral;',
            Db::USERNAME => 'sa',
            DB::PASSWORD => 'sql',
            Db::PDO_OPTIONS => [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]
        ],
        'sqlite' => [
            Db::TABLE_PREFIX => 'dbo_',
            Db::DSN => 'sqlite:' . ROOT . '\\writable\\data\\spektral.db',
            Db::USERNAME => '',
            DB::PASSWORD => '',
            Db::PDO_OPTIONS => [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]
        ]
    ]
];