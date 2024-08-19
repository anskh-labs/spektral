<?php

declare(strict_types=1);

namespace Faster\Http\Auth;

/**
 * AnonymousIdentity
 * -----------
 * Identitiy for guest or not athenticated user
 *
 * @author Khaerul Anas <khaerulanas@live.com>
 * @since 1.0.0
 * @package Faster\Http\Auth
 */
class UserIdentity implements UserIdentityInterface
{
    /**
     * __construct
     *
     * @param  string|int|null $id
     * @param  array $roles
     * @param  array $permissions
     * @param  array $data
     * @return void
     */
    public function __construct(private string|int|null $id = null, private array $roles = [], private array $permissions = [], private array $data = [])
    {
    }
    /**
     * @inheritdoc
     */
    public function getId(): string|int|null
    {
        return $this->id;
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
    public function getPermissions(): array
    {
        return $this->permissions;
    }
    /**
     * @inheritdoc
     */
    public function isAuthenticated(): bool
    {
        return empty($this->id) === false;
    }
    /**
     * @inheritdoc
     */
    public function getData(): array
    {
        return $this->data;
    }
}
