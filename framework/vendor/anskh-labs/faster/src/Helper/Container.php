<?php

declare(strict_types=1);

namespace Faster\Helper;

use Faster\Container\BasicContainer;

/**
 * Container
 * -----------
 * Container class for DI
 *
 * @author Khaerul Anas <khaerulanas@live.com>
 * @since 1.0.0
 * @package Faster\Helper
 */
class Container
{
    /**
     * get
     *
     * @param  string $id
     * @param  array|null $options
     * @return void
     */
    public static function get(string $id, array|null $params = null, bool $shared = false)
    {
        if ($shared) {
            return BasicContainer::getInstance()->getShared($id, $params);
        } else {
            return BasicContainer::getInstance()->get($id, $params);
        }
    }
}
