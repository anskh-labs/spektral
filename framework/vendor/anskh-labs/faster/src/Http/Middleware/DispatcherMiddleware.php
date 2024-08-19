<?php

declare(strict_types=1);

namespace Faster\Http\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * DispatcherMiddleware
 * -----------
 * DispatcherMiddleware
 *
 * @author Khaerul Anas <khaerulanas@live.com>
 * @since 1.0.0
 * @package Faster\Http\Middleware
 */
class DispatcherMiddleware implements MiddlewareInterface
{   
    private string $actionAttribute;

    /**
     * __construct
     *
     * @return void
     */
    public function __construct(string $actionAttribute = '__action')
    {
        $this->actionAttribute = $actionAttribute;
    }
    
    /**
     * process
     *
     * @param  ServerRequestInterface $request
     * @param  RequestHandlerInterface $handler
     * @return ResponseInterface
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $action = $request->getAttribute($this->actionAttribute);
        $response = $handler->handle($request);

        if (is_array($action) && is_string($action[0]) && is_string($action[1])) {
            $className = $action[0];
            $object = make($className);
            $response = $object->{$action[1]}($request, $response);
        } else {
            if (is_callable($action) === false) {
                $action = make($action);
            }
            $response = $action($request, $response);
        }

        return $response;
    }
}