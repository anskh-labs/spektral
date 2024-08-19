<?php

declare(strict_types=1);

namespace Faster\Http\Middleware;

use Faster\Http\Auth\AuthProviderInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Faster\Http\Auth\UserIdentity;
use Faster\Http\Auth\UserPrincipal;
use Faster\Http\Auth\UserPrincipalInterface;

/**
 * AuthMiddleware
 * -----------
 * AuthMiddleware
 *
 * @author Khaerul Anas <khaerulanas@live.com>
 * @since v1.0.0
 * @package Faster\Http\Middleware
 */
class AuthMiddleware implements MiddlewareInterface
{     
    public const USERID = 'userid';
    public const ROLES = 'roles';
    public const PERMISSIONS = 'permissions';
    public const DATA = 'data';

    /**
     * __construct
     *
     * @param  AuthProviderInterface $authProvider
     * @param  string $sessionAttribute
     * @param  string $userAttribute
     * @return void
     */
    public function __construct(private AuthProviderInterface $authProvider, private string $sessionAttribute = '__session', private string $userAttribute = '__user')
    {
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
        $user = $this->validateUser($request);        
        $request = $request->withAttribute($this->userAttribute, $user);

        return $handler->handle($request);
    }      
    /**
     * validateUser
     *
     * @param  ServerRequestInterface $request
     * @return UserPrincipalInterface
     */
    private function validateUser(ServerRequestInterface $request): UserPrincipalInterface
    {
        $session = $request->getAttribute($this->sessionAttribute);
        $userId = $session->get($this->authProvider->getUserIdAttribute());
        $userHash = $session->get($this->authProvider->getUserHashAttribute());
        if ($userId !== null && $userHash !== null) {
            $userData = array_decode($userHash);
            if(empty($userData) || $userId != $userData[self::USERID]){
                $session->unset($this->authProvider->getUserIdAttribute());
                $session->unset($this->authProvider->getUserHashAttribute());
            }else{
                $roles = $userData[self::ROLES] ?? [];
                $permissions = $userData[self::PERMISSIONS] ?? [];
                $data = $userData[self::DATA] ?? [];
                
                return new UserPrincipal($this->authProvider, new UserIdentity($userId, $roles, $permissions, $data));
            }
        }
        return new UserPrincipal($this->authProvider);
    }
}
