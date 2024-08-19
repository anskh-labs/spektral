<?php

declare(strict_types=1);

namespace Faster\Helper;

use Faster\Container\ConfigContainer;
use Exception;
use Faster\Component\Enums\EnvironmentEnum;
use InvalidArgumentException;

/**
 * Config
 * -----------
 * Class for working with @see Faster\Config\Config
 *
 * @author Khaerul Anas <khaerulanas@live.com>
 * @since 1.0.0
 * @package Faster\Helper
 */
class Config
{
    private static string|null $path = null;
    /**
     * init
     *
     * @param  string $path
     * @return void
     * @throws \InvalidArgumentException
     */
    public static function init(string $path): void
    {
        if (!$path && !is_dir($path)) {
            throw new InvalidArgumentException("Given path '{$path}'  is not valid.");
        }
        if (static::$path === null) {
            static::$path = $path;
            ConfigContainer::getInstance($path);
        }
    }

    /**
     * get
     *
     * @param  mixed $offset
     * @param  mixed $defaultValue
     * @return mixed
     */
    public static function get(mixed $offset, mixed $defaultValue = null)
    {
        return static::has($offset) ? ConfigContainer::getInstance(static::$path)->offsetGet($offset): $defaultValue;
    }

    /**
     * set
     *
     * @param  mixed $offset
     * @param  mixed $value
     * @return void
     */
    public static function set(mixed $offset, mixed $value): void
    {
        ConfigContainer::getInstance(static::$path)->offsetSet($offset, $value);
    }

    /**
     * has
     *
     * @param  mixed $offset
     * @return bool
     */
    public static function has(mixed $offset): bool
    {
        return ConfigContainer::getInstance(static::$path)->offsetExists($offset);
    }
    /**
     * path
     *
     * @return string
     */
    public static function path(): string
    {
        return static::$path;
    }
    /**
     * environment
     *
     * @return string
     */
    public static function environment(): string
    {
        return ConfigContainer::getInstance(static::$path)->getEnvironment();
    }
}
