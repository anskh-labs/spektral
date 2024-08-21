<?php

declare(strict_types=1);

defined('ROOT') or define('ROOT', __DIR__);
defined('FWPATH') or define('FWPATH', dirname(__DIR__) . '/framework');

if(getcwd() !== FWPATH){
    chdir(FWPATH);
}

/** load autoload composer */
require  'vendor/autoload.php';

/** Load .env file for read environment */
\Dotenv\Dotenv::createImmutable(FWPATH)->load();

/** run app */
\Faster\Helper\App::make('app/config')->run();
