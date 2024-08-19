<?php

declare(strict_types=1);

defined('ROOT') or define('ROOT', __DIR__);

/** set working directory */
if (getcwd() !== ROOT) {
    chdir(ROOT);
}

/** load autoload composer */
require 'vendor/autoload.php';

/** Load .env file for read environment */
\Dotenv\Dotenv::createImmutable(ROOT)->load();

/** set config folder and init component */
\Faster\Helper\Config::init('app/config');

$action = null;
if ($argc > 1) {
    $action = $argv[1];
}

if (!\Faster\Component\Enums\MigrationActionEnum::hasValue($action)) {
    echo "Available action are :" . implode(", ", \Faster\Component\Enums\MigrationActionEnum::values());
}

/** run console application */
make(\Faster\Console\Application::class, [make(\Faster\Console\MigrationCommand::class, [db(), 'migrations', 'migration']), $action])->run();
