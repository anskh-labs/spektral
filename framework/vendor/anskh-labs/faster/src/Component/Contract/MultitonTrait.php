<?php

declare(strict_types=1);

namespace Faster\Component\Contract;

/**
 * MultitonTrait
 * 
 * @author Khaerul Anas <khaerulanas@live.com>
 * @since 1.0.0
 * @package Faster\Component\Contract
 */
trait MultitonTrait
{
    private static array $instance = [];
    
    /**
     * getInstance
     *
     * @param  int|string $key
     * @return self
     */
    public static function getInstance(int|string $key): self
    {
        if (!array_key_exists($key, self::$instance)) {
            self::$instance[$key] = new self($key);
        }

        return self::$instance[$key];
    }
}