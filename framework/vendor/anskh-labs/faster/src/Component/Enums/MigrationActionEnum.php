<?php

declare(strict_types=1);

namespace Faster\Component\Enums;

/**
 * MigrationActionEnum
 * -----------
 * MigrationActionEnum
 *
 * @author Khaerul Anas <khaerulanas@live.com>
 * @since 1.0.0
 * @package Faster\Component\Enums
 */
class MigrationActionEnum extends BaseEnum
{
    public const UP = 'up';
    public const DOWN = 'down';
    public const SEED = 'seed';
}

