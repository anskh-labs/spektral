<?php

declare(strict_types=1);

use App\Enums\ResourceEnum;
use Faster\Helper\Router;
use Faster\Http\Auth\AuthProvider;
use Faster\Http\Middleware\AccessControlMiddleware;
use Faster\Http\Middleware\AuthMiddleware;
use Faster\Http\Middleware\DispatcherMiddleware;
use Faster\Http\Middleware\ExceptionHandlerMiddleware;
use Faster\Http\Middleware\MaintenanceCheckMiddleware;
use Faster\Http\Middleware\FastRouteMiddleware;
use Faster\Http\Middleware\SessionMiddleware;
use Laminas\Diactoros\Response;

return [
    ['id' => 'errorHandler', 'middleware' => make(ExceptionHandlerMiddleware::class, [config('errors'), make(Response::class), $_ENV['APP_ENV']])],
    ['id' => 'maintenance', 'middleware' => make(MaintenanceCheckMiddleware::class, [$_ENV['APP_MAINTENANCE'] == 'true', base_path('/maintenance'), base_path('/')])],
    ['id' => 'fastroute', 'middleware' => make(FastRouteMiddleware::class, [Router::make('routes')])],
    ['id' => 'session', 'middleware' => make(SessionMiddleware::class)],
    ['id' => 'auth', 'middleware' => make(AuthMiddleware::class, [
        make(AuthProvider::class, [
            route(ResourceEnum::LOGIN), route(ResourceEnum::LOGOUT), config('roles'), config('permissions')
        ])
    ])],
    ['id' => 'accessControl', 'middleware' => make(AccessControlMiddleware::class, [
        [base_path('/internal'), base_path('/permintaan-pembinaan')], 
        base_path('/internal'),
        'Silahkan login terlebih dahulu untuk mengakses halaman tersebut!', 
        'Anda tidak memiliki hak untuk mengakses halaman tersebut!', 
        route(ResourceEnum::LOGIN), 
        route(ResourceEnum::HOME),
        route(ResourceEnum::DASHBOARD)
        ])],
    ['id' => 'dispatcher', 'middleware' => make(DispatcherMiddleware::class)]
];
