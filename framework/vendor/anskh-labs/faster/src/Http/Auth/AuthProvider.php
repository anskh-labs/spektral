<?php

declare(strict_types=1);

namespace Faster\Http\Auth;

/**
 * AuthProvider
 * -----------
 * AuthProvider 
 *
 * @author Khaerul Anas <khaerulanas@live.com>
 * @since 1.0.0
 * @package Faster\Http\Auth
 */
class AuthProvider implements AuthProviderInterface
{
    /**
     * __construct
     *
     * @param  string $loginUri
     * @param  string $logoutUri
     * @param  array $roles
     * @param  array $rolePermissions
     * @return void
     */
    public function __construct(private string $loginUri = '', private string $logoutUri = '', private array $roles = [], private array $permissions = [])
    {
    }
    /**
     * @inheritdoc
     */
    public function getProvider(): string
    {
        return 'User Authentication';
    }
    /**
     * @inheritdoc
     */
    public function getLoginUri(): string
    {
        return $this->loginUri;
    }
    /**
     * @inheritdoc
     */
    public function getLogoutUri(): string
    {
        return $this->logoutUri;
    }
    /**
     * @inheritdoc
     */
    public function getRoles(): array
    {
        return $this->roles;
    }
    /**
     * @inheritdoc
     */
    public function getPermissions(array|null $roles = null): array
    {
        if(!empty($roles)){
            $permissions = [];
            foreach ($roles as $role) {
                $permissions = array_merge($permissions, $this->permissions[$role]);
            }
            return $permissions;
        }
        return $this->permissions;
    }
    /**
     * getUserHashAttribute
     *
     * @return string
     */
    public function getUserHashAttribute(): string
    {
        return '__user_hash';
    }
    /**
     * getUserIdAttribute
     *
     * @return string
     */
    public function getUserIdAttribute(): string
    {
        return '__user_id';
    }
}
