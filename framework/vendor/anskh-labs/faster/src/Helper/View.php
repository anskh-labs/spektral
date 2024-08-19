<?php

declare(strict_types=1);

namespace Faster\Helper;

use Faster\Http\Renderer\RendererInterface;
use Faster\Http\Renderer\Renderer;

/**
 * View
 * -----------
 * View
 *
 * @author Khaerul Anas <khaerulanas@live.com>
 * @since 1.0.0
 * @package Faster\Helper
 */
class View
{
    /**
     * renderer
     *
     * @param  null|string $path
     * @return RendererInterface
     */
    public static function renderer(null|string $path = null): RendererInterface
    { 
        $path = $path ?? static::defaultViewPath();
        return Renderer::getInstance($path);
    }    
    /**
     * defaultViewPath
     *
     * @return string
     */
    public static function defaultViewPath(): string
    {
        return config('app.view.path');
    }    
    /**
     * defaultViewExtension
     *
     * @return string
     */
    public static function defaultViewExtension(): string
    {
        return config('app.view.extension');
    }
}