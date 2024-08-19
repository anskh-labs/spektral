<?php

declare(strict_types=1);

namespace Faster\Container;

use ArrayAccess;
use Faster\Component\Contract\MultitonTrait;

/**
 * Configuration container
 * -----------
 * Configuration container for accessing 
 * app config folder with support dot notation
 *
 * @author Khaerul Anas <khaerulanas@live.com>
 * @since 1.0.0
 * @package Faster\Container
 */
class ConfigContainer implements ArrayAccess
{
    use MultitonTrait;

    private array $container = [];
    private string $env;

    /**
     * __construct
     *
     * @param  string $path
     * @return void
     */
    final private function __construct(private string $path)
    {
        $this->env = $_ENV['APP_ENV'] ?? 'development';
    }
    final function __clone()
    {
    }
    final function __wakeup()
    {
    }

    /**
     * @inheritdoc
     */
    public function offsetExists(mixed $offset): bool
    {
        if (isset($this->container[$offset])) {
            return true;
        }

        $name = strtok($offset, '.');
        if (isset($this->container[$name])) {
            $p = $this->container[$name];
            while (false !== ($name = strtok('.'))) {
                if (!isset($p[$name])) {
                    return false;
                }

                $p = $p[$name];
            }
            $this->container[$offset] = $p;

            return true;
        } else {
            $file = "{$this->path}/{$name}.php";
            if (is_file($file) && is_readable($file)) {
                $this->container[$name] = include $file;
                if ($this->env) {
                    $file = "{$this->path}/{$this->env}/{$name}.php";
                    if (is_file($file) && is_readable($file)) {
                        $this->container[$name] = array_replace_recursive($this->container[$name], include $file);
                    }
                }
                return $this->offsetExists($offset);
            } else {
                $file = "{$this->path}/{$this->env}/{$name}.php";
                if (is_file($file) && is_readable($file)) {
                    $this->container[$name] = include $file;
                    return $this->offsetExists($offset);
                }
            }

            return false;
        }
    }

    /**
     * @inheritdoc
     */
    public function offsetGet(mixed $offset): mixed
    {
        return $this->offsetExists($offset) ? $this->container[$offset] : null;
    }

    /**
     * @inheritdoc
     */
    public function offsetSet(mixed $offset, mixed $value): void
    {
        if (is_null($offset)) {
            $this->container[] = $value;
        } else {
            $this->container[$offset] = $value;
        }
    }

    /**
     * @inheritdoc
     */
    public function offsetUnset(mixed $offset): void
    {
        unset($this->container[$offset]);
    }
    /**
     * getPath
     *
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }
    /**
     * getEnvironment
     *
     * @return string
     */
    public function getEnvironment(): string
    {
        return $this->env;
    }
}
