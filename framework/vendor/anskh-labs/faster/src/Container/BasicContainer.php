<?php

declare(strict_types=1);

namespace Faster\Container;

use Faster\Component\Contract\SingletonTrait;

/**
 * Basic container
 * -----------
 * Basic container for get instance of class
 * based on full qualified name
 *
 * @author Khaerul Anas <khaerulanas@live.com>
 * @since 1.0.0
 * @package Faster\Container
 */
class BasicContainer
{
    use SingletonTrait;

    private array $container = [];    
    /**
     * __construct
     *
     * @return void
     */
    final private function __construct(){}

    /**
     * get
     *
     * @param  string $id
     * @param  array|null $params
     * @return mixed
     */
    public function get(string $id, array|null $params = null): mixed
    {
        if ($this->has($id)) {
            if (isset($this->container[$id])) {
                unset($this->container[$id]);
            }
            if ($params) {
                $obj = new $id(...$params);
            } else {
                $obj = new $id();
            }

            return $obj;
        }

        throw new \Exception("Class {$id} doesn't exists.");
    }
    /**
     * getShared
     *
     * @param  string $id
     * @param  array|null $params
     * @return mixed
     */
    public function getShared(string $id, array|null $params = null): mixed
    {
        if ($this->has($id)) {
            if (!isset($this->container[$id])) {
                if ($params) {
                    $obj = new $id(...$params);
                } else {
                    $obj = new $id();
                }
                $this->container[$id] = $obj;
            }

            return $this->container[$id];
        }

        throw new \Exception("Class {$id} doesn't exists.");
    }
    /**
     * has
     *
     * @param  string $id
     * @return bool
     */
    public function has(string $id): bool
    {
        return class_exists($id);
    }
}
