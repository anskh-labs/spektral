<?php

declare(strict_types=1);

namespace Faster\Http\Auth;

/**
 * UserPrincipalInterface
 * -----------
 * UserPrincipalInterface
 *
 * @author Khaerul Anas <khaerulanas@live.com>
 * @since 1.0.0
 * @package Faster\Http\Auth
 */
interface UserPrincipalInterface
{
    /**
     * getProvider
     *
     * @return AuthProviderInterface
     */
    public function getProvider(): AuthProviderInterface;
    /**
     * getIdentity
     *
     * @return UserIdentityInterface
     */
    public function getIdentity(): UserIdentityInterface;
    /**
     * hasRole
     *
     * @param  string|array $role
     * @return bool
     */
    public function hasRole(string|array $role): bool;
    /**
     * hasPermission
     *
     * @param  string|array $permission
     * @return bool
     */
    public function hasPermission(string|array $permission): bool;    
    /**
     * isGuest
     *
     * @return bool
     */
    public function isGuest(): bool;
}
