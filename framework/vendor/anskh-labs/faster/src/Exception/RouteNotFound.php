<?php declare(strict_types=1);

namespace Faster\Exception;

use Exception;

/**
 * RouteNotFound
 * -----------
 * Class to define RouteNotFound exception
 *
 * @author Khaerul Anas <khaerulanas@live.com>
 * @since 1.0.0
 * @package Faster\Exception
 */
class RouteNotFound extends Exception
{
    /**
     * __construct
     *
     * @param  string $route
     * @return void
     */
    public function __construct(private string $route)
    {
        $this->route = $route;
        parent::__construct("Route '" . $route . "' can not be found!");
    }
    
    /**
     * getRoute
     *
     * @return string
     */
    public function getRoute(): string
    {
        return $this->route;
    }
}
