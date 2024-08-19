<?php

declare (strict_types=1);

namespace App\Enums;

use Faster\Component\Enums\BaseEnum;

class StatusPermintaanEnum extends BaseEnum
{
    public const OPEN = 1;
    public const IN_PROGRESS = 2;
    public const AWAITING_REPLY = 3;
    public const APPROVED = 4;
    public const CLOSED = 5;
}