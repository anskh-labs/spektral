<?php

declare(strict_types=1);

namespace Faster\Http\Router;

use FastRoute\Dispatcher;

/**
 * RouterInterface
 * -----------
 * Abstraction for Router
 *
 * @author Khaerul Anas <khaerulanas@live.com>
 * @since 1.0.0
 * @package Faster\Http\Router
 */
interface RouterInterface
{
    /**
     * getDispatcher
     *
     * @return Dispatcher
     */
    public function getDispatcher(): Dispatcher;
    /**
     * getRoutes
     *
     * @return array
     */
    public function getRoutes(): array;
    /**
     * getRoute
     *
     * @return array
     */
    public function getRoute(string $name): array;
    /**
     * routeExists
     *
     * @return bool
     */
    public function routeExists(string $name): bool;    
    /**
     * addRoute
     *
     * @param  string $name
     * @param  array $route
     * @return void
     */
    public function addRoute(string $name, array $route);    
    /**
     * getRouteName
     *
     * @param  string|null $path
     * @return string
     */
    public function getRouteName(string|null $path = null): string;
}