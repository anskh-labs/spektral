<?php

declare(strict_types=1);

namespace Faster\Http\Middleware;

use Faster\Component\Enums\ErrorTypeEnum;
use Faster\Exception\CsrfFailure;
use Faster\Exception\MethodNotAllowed;
use Faster\Exception\RouteNotFound;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Throwable;

/**
 * ExceptionHandlerMiddleware
 * -----------
 * ExceptionHandlerMiddleware
 *
 * @author Khaerul Anas <khaerulanas@live.com>
 * @since 1.0.0
 * @package Faster\Http\Middleware
 */
class ExceptionHandlerMiddleware implements MiddlewareInterface
{
    /** @var callable */
    private $notfound;
    /** @var callable */
    private $notAllowed;
    /** @var callable */
    private $systemError;
    private ResponseInterface $response;

    /**
     * __construct
     *
     * @param  array $config
     * @param  ResponseInterface $response
     * @return void
     */
    public function __construct(array $config, ResponseInterface $response)
    {
        if (isset($config[ErrorTypeEnum::NOT_FOUND]) && is_callable($config[ErrorTypeEnum::NOT_FOUND])) {
            $this->notfound = $config[ErrorTypeEnum::NOT_FOUND];
        }
        if (isset($config[ErrorTypeEnum::NOT_ALLOWED]) && is_callable($config[ErrorTypeEnum::NOT_ALLOWED])) {
            $this->notAllowed = $config[ErrorTypeEnum::NOT_ALLOWED];
        }
        if (isset($config[ErrorTypeEnum::SYSTEM_ERROR]) && is_callable($config[ErrorTypeEnum::SYSTEM_ERROR])) {
            $this->systemError = $config[ErrorTypeEnum::SYSTEM_ERROR];
        }
        $this->response = $response;
    }    
    /**
     * @inheritdoc
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        try {
            return $handler->handle($request);
        } catch (RouteNotFound $e) {
            return $this->handleNotFound($e);
        } catch (MethodNotAllowed $e) {
            return $this->handleNotAllowed($e);
        } catch (Throwable $exception) {
            return $this->handleThrowable($exception);
        }
    }

    /**
     * handleNotFound
     *
     * @param  RouteNotFound $e
     * @return ResponseInterface
     */
    private function handleNotFound(RouteNotFound $e): ResponseInterface
    {
        if(is_callable($this->notfound)){
            return ($this->notfound)($e, $this->response);
        }

        return $this->handleException($e->getMessage(), 404);
    }
    
    /**
     * handleNotAllowed
     *
     * @param  MethodNotAllowed $e
     * @return ResponseInterface
     */
    private function handleNotAllowed(MethodNotAllowed $e): ResponseInterface
    {
        if(is_callable($this->notAllowed)){
         return ($this->notAllowed)($e, $this->response);
        }

        return $this->handleException($e->getMessage(), 403);
    }
    
    /**
     * handleThrowable
     *
     * @param  Throwable $e
     * @return ResponseInterface
     */
    private function handleThrowable(Throwable $e): ResponseInterface
    {
        if(is_callable($this->systemError)){
            return ($this->systemError)($e, $this->response);
        }

        return $this->handleException($e->getMessage(), 500);        
    }
    
    /**
     * handleException
     *
     * @param  string $message
     * @param  int $status
     * @return ResponseInterface
     */
    private function handleException(string $message, int $status): ResponseInterface
    {
        $body = $this->response->getBody();
        $body->write($message);
        return $this->response
            ->withStatus($status)
            ->withHeader('Content-Type', 'text/plain')
            ->withBody($body);
    }
}
