<?php

declare(strict_types=1);

namespace Faster\Http\Auth;

/**
 * UserIdentityInterface
 * -----------
 * Identity contract
 *
 * @author Khaerul Anas <khaerulanas@live.com>
 * @since 1.0.0
 * @package Faster\Http\Auth
 */
interface UserIdentityInterface
{
    /**
     * getId
     *
     * @return string|int|null
     */
    public function getId() : string|int|null;
    /**
     * getRoles
     *
     * @return array
     */
    public function getRoles(): array;
    /**
     * getPermissions
     *
     * @return array
     */
    public function getPermissions(): array;
    /**
     * isAuthenticated
     *
     * @return bool
     */
    public function isAuthenticated(): bool;
    /**
     * getData
     *
     * @return array
     */
    public function getData(): array;
}
