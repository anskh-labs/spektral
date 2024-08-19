<?php

declare (strict_types=1);

namespace App\Enums;

use Faster\Component\Enums\BaseEnum;

class RoleEnum extends BaseEnum
{
    public const USER = 'user';
    public const OPERATOR = 'operator';
    public const SUPERVISOR = 'supervisor';
    public const VIEWER = 'viewer';
    public const ADMIN = 'admin';
}