<?php

declare(strict_types=1);

namespace Faster\Console;

/**
 * CommandInterface
 * -----------
 * CommandInterface
 *
 * @author Khaerul Anas <khaerulanas@live.com>
 * @since 1.0.0
 * @package Faster\Console
 */
interface CommandInterface
{    
    /**
     * execute
     *
     * @param  string $action
     * @return void
     */
    public function execute(string $action);
}