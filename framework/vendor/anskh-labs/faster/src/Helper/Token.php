<?php

declare(strict_types=1);

namespace Faster\Helper;

/**
 * Token
 * -----------
 * Class for working with token
 *
 * @author Khaerul Anas <khaerulanas@live.com>
 * @since 1.0.0
 * @package Faster\Helper
 */
class Token
{    
    /**
     * generateToken
     * 
     * Generate hexadecimal charected with specific length, default 40
     *
     * @param  mixed $length
     * @return string
     */
    public static function generateToken(int $length = 40): string
    {
        return bin2hex(random_bytes($length));
    }
    /**
     * generateMD5Token
     * 
     * generate 32 hexadecimal character
     *
     * @return string
     */
    public static function generateMD5Token(): string
    {
        return md5(random_bytes(64));
    }
    /**
     * generateSha1Token
     * 
     * Generate 40 hexadecimal character
     *
     * @return string
     */
    public static function generateSha1Token(): string
    {
        return sha1(random_bytes(64));
    }
}
