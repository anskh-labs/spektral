<?php

declare(strict_types=1);

namespace Faster\Http\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * AccessControlMiddleware
 * -----------
 * AccessControlMiddleware
 *
 * @author Khaerul Anas <khaerulanas@live.com>
 * @since v1.0.0
 * @package Faster\Http\Middleware
 */
class AccessControlMiddleware implements MiddlewareInterface
{
    /**
     * __construct
     *
     * @param array $prefixSecurePaths
     * @param string $prefixInternalPath
     * @param string $loginMessage
     * @param string $forbiddenMessage
     * @param string $loginUri
     * @param string $redirectUri
     * @param string $redirectInternalUri
     * @param string $userAttribute
     * @param string $routeAttribute
     * @return void
     */
    public function __construct(
        private array $prefixSecurePaths,
        private string $prefixInternalPath,
        private string $loginMessage,
        private string $forbiddenMessage,
        private string $loginUri,
        private string $redirectUri,
        private string $redirectInternalUri,
        private string $userAttribute = '__user',
        private string $routeAttribute = '__route'
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
        $isSecure = false;
        foreach ($this->prefixSecurePaths as $securePath) {
            if (str_starts_with($path, $securePath)) {
                $isSecure = true;
                break;
            }
        }

        if (!$isSecure) {
            return $handler->handle($request);
        }

        $user = $request->getAttribute($this->userAttribute);
        $route = $request->getAttribute($this->routeAttribute);
        if ($user->isGuest()) {
            session()->addFlashWarning($this->loginMessage);
            return redirect_uri($this->loginUri . '?redirect_uri=' . route($route));
        }
 
        if ($route && !$user->hasPermission($route)) {
            session()->addFlashWarning($this->forbiddenMessage);
            if (str_starts_with($path, $this->prefixInternalPath)) {
                return redirect_uri($this->redirectInternalUri);
            } else {
                return redirect_uri($this->redirectUri);
            }
        }

        return $handler->handle($request);
    }
}
