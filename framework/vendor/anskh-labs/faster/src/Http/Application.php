<?php

declare(strict_types=1);

namespace Faster\Http;

use Faster\Component\Contract\MultitonTrait;
use Faster\Helper\Config;
use Faster\Http\Handler\HttpRequestHandler;
use Faster\Http\Handler\HttpRequestHandlerInterface;
use Laminas\Diactoros\Response;
use Laminas\Diactoros\ServerRequestFactory;
use Laminas\HttpHandlerRunner\Emitter\EmitterInterface;
use Laminas\HttpHandlerRunner\Emitter\SapiEmitter;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Throwable;

/**
 * Application
 * -----------
 * Application
 *
 * @author Khaerul Anas <khaerulanas@live.com>
 * @since 1.0.0
 * @package Faster\Http
 */
class Application
{
    use MultitonTrait;

    private EmitterInterface|null $emitter = null;
    private ServerRequestInterface|null $request = null;
    private HttpRequestHandlerInterface|null $requestHandler = null;
    private ResponseInterface|null $response = null;


    /**
     * __construct
     *
     * @param  string $configPath
     * @return void
     */
    final private function __construct(private string $configPath)
    {
        Config::init($configPath);
        $this->response = make(Response::class);
        $this->requestHandler = make(HttpRequestHandler::class, [config('middlewares'), $this->response]);
        $this->request = ServerRequestFactory::fromGlobals();
        $this->emitter = make(SapiEmitter::class);
    }
    final function __clone()
    {
    }
    final function __wakeup()
    {
    }

    /**
     * run
     *
     * @return void
     */
    public function run(): void
    {
        $this->response = $this->requestHandler->handle($this->request);

        if (headers_sent() === false) {
            $this->emitter->emit($this->response);
        }
    }
    /**
     * getResponse
     *
     * @return ResponseInterface
     */
    public function getResponse(): ResponseInterface
    {
        return $this->requestHandler->getResponse();
    }
    /**
     * getRequest
     *
     * @return ServerRequestInterface
     */
    public function getRequest(): ServerRequestInterface
    {
        return $this->requestHandler->getRequest();
    }
}
