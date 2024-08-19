<?php declare(strict_types=1);

namespace Faster\Helper;

/**
 * Html
 * -----------
 * Class for generate html component
 *
 * @author Khaerul Anas <khaerulanas@live.com>
 * @since 1.0.0
 * @package Faster\Helper
 */
class Html 
{        
    /**
     * tag
     *
     * @param  mixed $tag
     * @param  mixed $content
     * @param  mixed $options
     * @return string
     */
    public static function tag(string $tag, string $content = '', array $options = []): string
    {
        return "<$tag" . attr_to_string($options) . ">$content</$tag>" . PHP_EOL;
    }    
    /**
     * beginTag
     *
     * @param  mixed $tag
     * @param  mixed $options
     * @return string
     */
    public static function beginTag(string $tag, array $options = []): string
    {
        return "<$tag" . attr_to_string($options) . ">" . PHP_EOL;
    }    
    /**
     * endTag
     *
     * @param  mixed $tag
     * @return string
     */
    public static function endTag(string $tag): string
    {
        return "</$tag>" . PHP_EOL;
    }    
    /**
     * beginForm
     *
     * @param  mixed $action
     * @param  mixed $method
     * @param  mixed $options
     * @return string
     */
    public static function beginForm(string $action = '', string $method = 'POST', array $options = []): string
    {
        return "<form action=\"$action\" method=\"$method\"" . attr_to_string($options) . ">" . PHP_EOL;
    } 
    /**
     * endForm
     *
     * @return string
     */
    public static function endForm(): string
    {
        return static::endTag('form');
    }    
    /**
     * input
     *
     * @param  mixed $name
     * @param  mixed $type
     * @param  mixed $options
     * @return string
     */
    public static function input(string $name, string $type= 'text', array $options = []): string
    {
        return "<input name=\"$name\" type=\"$type\"" . attr_to_string($options) . ">" . PHP_EOL;
    }    
    /**
     * img
     *
     * @param  mixed $src
     * @param  mixed $options
     * @return string
     */
    public static function img(string $src, array $options = []): string
    {
        return "<img src=\"$src\"" . attr_to_string($options) . ">" . PHP_EOL;
    }    
    /**
     * select
     *
     * @param  mixed $name
     * @param  mixed $options
     * @return string
     */
    public static function beginSelect(string $name, array $options = []): string
    {
        return "<select name=\"$name\"" . attr_to_string($options) . ">" . PHP_EOL;
    }    
    /**
     * endSelect
     *
     * @return string
     */
    public static function endSelect(): string
    {
        return static::endTag('select');
    }    
    /**
     * a
     *
     * @param  mixed $href
     * @param  mixed $options
     * @return string
     */
    public static function a(string $href, array $options = []): string
    {
        $options['href'] = $href;
        return static::tag('a', $options);
    }
}