<?php

declare(strict_types=1);

namespace Faster\Console;

/**
 * Application
 * -----------
 * Application
 *
 * @author Khaerul Anas <khaerulanas@live.com>
 * @since 1.0.0
 * @package Faster\Console
 */
class Application
{ 
    /**
     * __construct
     *
     * @param  CommandInterface $command
     * @param  string $action
     * @return void
     */
    public function __construct(private CommandInterface $command, private string $action)
    {
    }
    
    /**
     * run
     *
     * @return void
     */
    public function run(): void
    {
        $this->command->execute($this->action);
    }
}
