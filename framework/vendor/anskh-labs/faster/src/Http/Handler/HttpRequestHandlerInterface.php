<?php

declare(strict_types=1);

namespace Faster\Http\Handler;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * HttpRequestHandlerInterface
 *
 * @author Khaerul Anas <khaerulanas@live.com>
 * @since v1.0.0
 * @package Faster\Http\Handler
 */
interface HttpRequestHandlerInterface extends RequestHandlerInterface
{    
    /**
     * getRequest
     *
     * @return ServerRequestInterface
     */
    public function getRequest(): ServerRequestInterface;    
    /**
     * getResponse
     *
     * @return ResponseInterface
     */
    public function getResponse(): ResponseInterface;
    
}