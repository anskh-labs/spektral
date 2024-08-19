<?php

declare(strict_types=1);

use App\Enums\PathEnum;

return [
    'name' => $_ENV['APP_NAME'] ?? '',
    'version' => $_ENV['APP_VERSION'] ?? '',
    'env' => $_ENV['APP_ENV'] ?? 'development',
    'debug' => ($_ENV['APP_DEBUG'] ?? 'true') == 'true',
    'url' => $_ENV['APP_URL'] ?? 'http://localhost',
    'is_maintenance' => ($_ENV['APP_MAINTENANCE'] ?? 'true') == 'true',
    'view' => [
        'path' => 'app/views',
        'extension' => '.phtml'
    ],

    'max_upload_size' => 8388608, // 8MB
    'max_image_size' =>  1024000, // 1MB

    PathEnum::PERMINTAAN_PEMBINAAN => '/uploads/permintaan_pembinaan',
    PathEnum::MODUL_PEMBINAAN => '/uploads/modul_pembinaan',
    PathEnum::MODUL_GSBPM => '/uploads/modul_gsbpm',
    PathEnum::MODUL_LITERASI => '/uploads/modul_literasi',
    PathEnum::IMAGE_DOKUMENTASI_PEMBINAAN => '/uploads/dokumentasi_pembinaan/images'
];