<?php

declare(strict_types=1);

namespace Faster\Helper;

use Faster\Http\Router\Router as SimpleRouter;
use Faster\Http\Router\RouterInterface;

/**
 * Router
 * -----------
 * Router
 *
 * @author Khaerul Anas <khaerulanas@live.com>
 * @since 1.0.0
 * @package Faster\Helper
 */
class Router
{  
    private static string $route;
    /**
     * make
     *
     * @param  string $route
     * @return RouterInterface
     */
    public static function make(string $route): RouterInterface
    {
        static::$route = $route;
        return SimpleRouter::getInstance($route);
    }
    /**
     * get route definition based on route name
     *
     * @return array
     */
    public static function get(string $name): array
    {
        return SimpleRouter::getInstance(static::$route)->getRoute($name);
    }    
    /**
     * exists
     *
     * @param  string $name
     * @return bool
     */
    public static function exists(string $name): bool
    {
        return SimpleRouter::getInstance(static::$route)->routeExists($name);
    } 
    /**
     * get route name based on url path
     *
     * @param  string|null $path
     * @return string
     */
    public static function getName(string|null $path = null): string
    {
        return SimpleRouter::getInstance(static::$route)->getRouteName($path);
    }
}
