<?php

declare(strict_types=1);

namespace Faster\Component\Contract;

/**
 * SingletonTrait
 * 
 * @author Khaerul Anas <khaerulanas@live.com>
 * @since 1.0.0
 * @package Faster\Component\Contract
 */
trait SingletonTrait
{
    private static self|null $instance = null;

    final function __clone(){}
    final function __wakeup(){}
    
    /**
     * getInstance
     *
     * @return static
     */
    public static function getInstance(): static
    {
        if (static::$instance === null) {
            static::$instance = new static;
        }

        return static::$instance;
    }
}