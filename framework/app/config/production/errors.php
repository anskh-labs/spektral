<?php

declare(strict_types=1);

use Faster\Component\Enums\ErrorTypeEnum;
use Faster\Exception\MethodNotAllowed;
use Faster\Exception\RouteNotFound;
use Monolog\Handler\FirePHPHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Psr\Http\Message\ResponseInterface;

return [
    ErrorTypeEnum::NOT_FOUND => function (RouteNotFound $e, ResponseInterface $response) {
        return view('404', ['title' => 'Kesalahan 404 | SPEKTRAL', 'error'=>$e], $response, 'error');
    },
    ErrorTypeEnum::NOT_ALLOWED => function (MethodNotAllowed $e, ResponseInterface $response) {
        return view('403', ['title' => 'Kesalahan 403 | SPEKTRAL', 'error'=>$e], $response, 'error');
    },
    ErrorTypeEnum::SYSTEM_ERROR => function (Throwable $e, ResponseInterface $response): ResponseInterface {
        $debug = (bool)$_ENV['APP_DEBUG'] ?? true;
        if($debug) {
            $logger = make(Logger::class, ['spektral']);
            $logger->pushHandler(make(StreamHandler::class, ["writable\\log\\app_" . date('Y-m-d') . ".log"]));
            $logger->pushHandler(make(FirePHPHandler::class));
            $logger->error($e->getMessage());
        }

        return view('500', ['title' => 'Kesalahan 500 | SPEKTRAL', 'error'=>$e], $response, 'error');
    }
];
