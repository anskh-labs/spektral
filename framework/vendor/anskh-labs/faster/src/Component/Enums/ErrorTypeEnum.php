<?php

declare(strict_types=1);

namespace Faster\Component\Enums;

/**
 * ErrorTypeEnum
 * -----------
 * ErrorTypeEnum
 *
 * @author Khaerul Anas <khaerulanas@live.com>
 * @since 1.0.0
 * @package Faster\Component\Enums
 */
class ErrorTypeEnum extends BaseEnum
{
    public const NOT_FOUND = '404';
    public const NOT_ALLOWED = '403';
    public const SYSTEM_ERROR  = '500';
}
