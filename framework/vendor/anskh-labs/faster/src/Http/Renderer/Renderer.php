<?php

declare(strict_types=1);

namespace Faster\Http\Renderer;

use Faster\Component\Contract\MultitonTrait;
use Faster\Helper\View;

/**
 * Renderer
 * -----------
 * Renderer
 *
 * @author Khaerul Anas <khaerulanas@live.com>
 * @since 1.0.0
 * @package Faster\Http\Renderer
 */
class Renderer implements RendererInterface
{
    use MultitonTrait;
    
    private array $params = [];
    private string $fileExtension;

    /**
     * __construct
     *
     * @param  string $viewPath
     * @param  string $fileExtension
     * @return void
     */
    final private function __construct(private string $viewPath)
    {
        $this->fileExtension = View::defaultViewExtension();
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
    public function render(string $view, array $params = []): string
    {
        if (!empty($params)) {
            $this->params = array_merge($this->params, $params);
        }
        extract($this->params, EXTR_SKIP);
        $filename = $this->viewPath . '/' . $view . $this->fileExtension;
        ob_start();
        if (file_exists($filename))
            require $filename;
        else
            echo "File '$filename' doesn't exists.";
        return ob_get_clean();
    }
    /**
     * @inheritdoc
     */
    public function getParam(string|null $key = null, $defaultValue = null)
    {
        if ($key) {
            return $this->params[$key] ?? $defaultValue;
        }

        return $this->params;
    }
    /**
     * @inheritdoc
     */
    public function setParam(string $key, $value): void
    {
        $this->params[$key] = $value;
    }
}
