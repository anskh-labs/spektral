<?php declare(strict_types=1);

namespace Faster\Http\Renderer;

/**
 * ViewRendererInterface
 * -----------
 * ViewRendererInterface
 *
 * @author Khaerul Anas <khaerulanas@live.com>
 * @since 1.0.0
 * @package Faster\Http\Renderer
 */
Interface RendererInterface
{    
    /**
     * render
     *
     * @param  string $view
     * @param  array $params
     * @return string
     */
    public function render(string $view, array $params = []): string;
    /**
     * getParam
     *
     * @param  string|null $key
     * @param  mixed $defaultValue
     * @return mixed
     */
    public function getParam(string|null $key = null, $defaultValue = null);
    /**
     * setParam
     *
     * @param  string $key
     * @param  mixed $defaultValue
     * @return void
     */
    public function setParam(string $key, $value): void;
}