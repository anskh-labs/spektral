<?php declare(strict_types=1);

namespace Faster\Exception;

use Exception;

/**
 * MethodNotAllowed
 * -----------
 * Class to define MethodNotAllowed exception
 *
 * @author Khaerul Anas <khaerulanas@live.com>
 * @since 1.0.0
 * @package Faster\Exception
 */
class MethodNotAllowed extends Exception
{    
    /**
     * __construct
     *
     * @param  string $method
     * @return void
     */
    public function __construct(private string $method)
    {
        parent::__construct("Method '" . $method . "' is not allowed!");
    }
    
    /**
     * getMethod
     *
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }
}
