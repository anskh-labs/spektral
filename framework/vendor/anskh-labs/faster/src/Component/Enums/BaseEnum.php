<?php

declare(strict_types=1);

namespace Faster\Component\Enums;

use ReflectionClass;
use Throwable;

/**
 * BaseEnum
 * -----------
 * BaseEnum
 *
 * @author Khaerul Anas <khaerulanas@live.com>
 * @since 1.0.0
 * @package Faster\Component\Enums
 */
abstract class BaseEnum
{
    /**
     * All the items declared in enum
     *
     * @var array
     */
    protected static array $items = [];

    /**
     * Get all the items in the enum
     * 
     * @return array
     */
    public static function all(): array
    {
        try {
            return static::$items[static::class] ?? (static::$items[static::class] = (new ReflectionClass(static::class))->getConstants());
        } catch (Throwable $e) {
            return [];
        }
    }

    /**
     * Get all the declared keys
     * 
     * @return array
     */
    public static function keys(): array
    {
        return array_keys(static::all());
    }

    /**
     * Get all the declared values
     * 
     * @return array
     */
    public static function values(): array
    {
        return array_values(static::all());
    }

    /**
     * Check if the given key declared in the enum or not
     * 
     * @param  string $key
     * @return bool
     */
    public static function hasKey(string $key): bool
    {
        return array_key_exists($key, static::all());
    }

    /**
     * Check if the given value declared in the enum or not
     *
     * @param mixed $value
     * @return bool
     */
    public static function hasValue(mixed $value): bool
    {
        return in_array($value, static::all());
    }

    /**
     * Get value of the given key
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public static function valueOf(string $key, mixed $default = null): mixed
    {
        return static::all()[$key] ?? $default;
    }

    /**
     * Get related keys of the given value
     *
     * @param mixed $value
     * @return array
     */
    public static function keysOf(mixed $value): array
    {
        $keys = [];

        foreach (static::all() as $k => $v) {
            if ($v == $value) {
                $keys[] = $k;
            }
        }

        return $keys;
    }

    /**
     * Get only the first related key of the given value
     *
     * @param mixed $value
     * @param mixed $default
     * @return mixed
     */
    public static function keyOf(mixed $value, mixed $default = null): mixed
    {
        return static::keysOf($value)[0] ?? $default;
    }    
    /**
     * defaultType
     *
     * @return string
     */
    public static function defaultType(): string
    {
        return static::all()[0];
    }
}
