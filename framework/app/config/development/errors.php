<?php

declare(strict_types=1);

use Faster\Component\Enums\ErrorTypeEnum;
use Faster\Exception\MethodNotAllowed;
use Faster\Exception\RouteNotFound;
use Psr\Http\Message\ResponseInterface;
use Whoops\Handler\PrettyPageHandler;
use Whoops\Run;

return [
    ErrorTypeEnum::NOT_FOUND => function (RouteNotFound $e, ResponseInterface $response): ResponseInterface {
        $message = $e->getMessage();
        $response->getBody()->write("<h1>Error 404</h1> <p>{$message}</p>");

        return $response->withStatus(404);
    },
    ErrorTypeEnum::NOT_ALLOWED => function (MethodNotAllowed $e, ResponseInterface $response): ResponseInterface {
        $message = $e->getMessage();
        $response->getBody()->write("<h1>Error 403</h1> <p>{$message}</p>");

        return $response->withStatus(403);
    },
    ErrorTypeEnum::SYSTEM_ERROR => function (Throwable $e, ResponseInterface $response): ResponseInterface {

        $debug = (bool)$_ENV['APP_DEBUG'] ?? true;
        if($debug) {
            $whoops = make(Run::class);
            $whoops->allowQuit(false);
            $whoops->writeToOutput(false);
            $whoops->pushHandler(make(PrettyPageHandler::class));
            $output = $whoops->handleException($e);
            $response->getBody()->write($output);
        }else{
            $response->getBody()->write('<h1>Error 500</h1> <p>' . $e->getMessage() . '</p>');
        }
        return $response->withStatus(500);
    }
];