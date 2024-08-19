<?php

declare(strict_types=1);

namespace Faster\Http\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use function strcmp;

/**
 * MaintenanceCheckMiddleware
 * -----------
 * MaintenanceCheckMiddleware
 *
 * @author Khaerul Anas <khaerulanas@live.com>
 * @since v1.0.0
 * @package Faster\Http\Middleware
 */
class MaintenanceCheckMiddleware implements MiddlewareInterface
{
    /**
     * __construct
     *
     * @param bool $isMaintenanceMode
     * @param string $maintenanceUri
     * @param string $homeUri
     * @return void
     */
    public function __construct(
        private bool $isMaintenanceMode,
        private string $maintenanceUri,
        private string $homeUri
    ) {
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
        $path = current_path();
        if ($this->isMaintenanceMode) {
            if(strcmp($path, $this->maintenanceUri) !== 0) {
                return redirect_uri($this->maintenanceUri);
            } 
        }else{
            if(strcmp($path, $this->maintenanceUri) === 0) {
                return redirect_uri($this->homeUri);
            }
        }

        return $handler->handle($request);
    }
}
