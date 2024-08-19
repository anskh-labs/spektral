<?php

declare(strict_types=1);

namespace Faster\Component\Escaper;

use InvalidArgumentException;
use RuntimeException;

use function bin2hex;
use function ctype_digit;
use function hexdec;
use function htmlspecialchars;
use function in_array;
use function mb_convert_encoding;
use function ord;
use function preg_match;
use function preg_replace_callback;
use function rawurlencode;
use function sprintf;
use function strlen;
use function strtolower;
use function strtoupper;
use function substr;

use const ENT_QUOTES;
use const ENT_SUBSTITUTE;

/**
 * Escaper
 * -----------
 * Escaper, modified from CI4
 *
 * @author Khaerul Anas <khaerulanas@live.com>
 * @since 1.0.0
 * @package Faster\Component\Escaper
 */
class Escaper
{
    protected static array $htmlNamedEntityMap = [
        34 => 'quot', // quotation mark
        38 => 'amp', // ampersand
        60 => 'lt', // less-than sign
        62 => 'gt', // greater-than sign
    ];
    protected $htmlSpecialCharsFlags;
    protected $htmlAttrMatcher;
    protected $jsMatcher;
    protected $cssMatcher;
    protected array $supportedEncodings = [
        'iso-8859-1',
        'iso8859-1',
        'iso-8859-5',
        'iso8859-5',
        'iso-8859-15',
        'iso8859-15',
        'utf-8',
        'cp866',
        'ibm866',
        '866',
        'cp1251',
        'windows-1251',
        'win-1251',
        '1251',
        'cp1252',
        'windows-1252',
        '1252',
        'koi8-r',
        'koi8-ru',
        'koi8r',
        'big5',
        '950',
        'gb2312',
        '936',
        'big5-hkscs',
        'shift_jis',
        'sjis',
        'sjis-win',
        'cp932',
        '932',
        'euc-jp',
        'eucjp',
        'eucjp-win',
        'macroman',
    ];
    
    /**
     * __construct
     *
     * @param  mixed $encoding
     * @return void
     */
    public function __construct(private string $encoding = 'utf-8')
    {
        if ($this->encoding === '') {
            throw new InvalidArgumentException(
                static::class . ' constructor parameter does not allow a blank value'
            );
        }

        $this->encoding = strtolower($this->encoding);
        if (! in_array($this->encoding, $this->supportedEncodings)) {
            throw new InvalidArgumentException(
                'Value of \'' . $this->encoding . '\' passed to ' . static::class
                . ' constructor parameter is invalid. Provide an encoding supported by htmlspecialchars()'
            );
        }        

        // We take advantage of ENT_SUBSTITUTE flag to correctly deal with invalid UTF-8 sequences.
        $this->htmlSpecialCharsFlags = ENT_QUOTES | ENT_SUBSTITUTE;

        // set matcher callbacks
        $this->htmlAttrMatcher = [$this, 'htmlAttrMatcher'];
        $this->jsMatcher       = [$this, 'jsMatcher'];
        $this->cssMatcher      = [$this, 'cssMatcher'];
    }
    
    /**
     * getEncoding
     *
     * @return string
     */
    public function getEncoding(): string
    {
        return $this->encoding;
    }
    
    /**
     * escapeHtml
     *
     * @param  mixed $string
     * @return string
     */
    public function escapeHtml(string $string): string
    {
        return htmlspecialchars($string, $this->htmlSpecialCharsFlags, $this->encoding);
    }

    /**
     * escapeHtmlAttr
     *
     * @param  mixed $string
     * @return string
     */
    public function escapeHtmlAttr(string $string): string
    {
        $string = $this->toUtf8($string);
        if ($string === '' || ctype_digit($string)) {
            return $string;
        }

        $result = preg_replace_callback('/[^a-z0-9,\.\-_]/iSu', $this->htmlAttrMatcher, $string);
        return $this->fromUtf8($result);
    }
        
    /**
     * escapeJs
     *
     * @param  mixed $string
     * @return string
     */
    public function escapeJs(string $string):string
    {
        $string = $this->toUtf8($string);
        if ($string === '' || ctype_digit($string)) {
            return $string;
        }

        $result = preg_replace_callback('/[^a-z0-9,\._]/iSu', $this->jsMatcher, $string);
        return $this->fromUtf8($result);
    }
    
    /**
     * escapeUrl
     *
     * @param  mixed $string
     * @return string
     */
    public function escapeUrl(string $string):string
    {
        return rawurlencode($string);
    }
    
    /**
     * escapeCss
     *
     * @param  mixed $string
     * @return string
     */
    public function escapeCss(string $string):string
    {
        $string = $this->toUtf8($string);
        if ($string === '' || ctype_digit($string)) {
            return $string;
        }

        $result = preg_replace_callback('/[^a-z0-9]/iSu', $this->cssMatcher, $string);
        return $this->fromUtf8($result);
    }
    
    /**
     * htmlAttrMatcher
     *
     * @param  mixed $matches
     * @return string
     */
    protected function htmlAttrMatcher($matches): string
    {
        $chr = $matches[0];
        $ord = ord($chr);

        /**
         * The following replaces characters undefined in HTML with the
         * hex entity for the Unicode replacement character.
         */
        if (
            ($ord <= 0x1f && $chr !== "\t" && $chr !== "\n" && $chr !== "\r")
            || ($ord >= 0x7f && $ord <= 0x9f)
        ) {
            return '&#xFFFD;';
        }

        /**
         * Check if the current character to escape has a name entity we should
         * replace it with while grabbing the integer value of the character.
         */
        if (strlen($chr) > 1) {
            $chr = $this->convertEncoding($chr, 'UTF-32BE', 'UTF-8');
        }

        $hex = bin2hex($chr);
        $ord = hexdec($hex);
        if (isset(static::$htmlNamedEntityMap[$ord])) {
            return '&' . static::$htmlNamedEntityMap[$ord] . ';';
        }

        /**
         * Per OWASP recommendations, we'll use upper hex entities
         * for any other characters where a named entity does not exist.
         */
        if ($ord > 255) {
            return sprintf('&#x%04X;', $ord);
        }
        return sprintf('&#x%02X;', $ord);
    }
    
    /**
     * jsMatcher
     *
     * @param  mixed $matches
     * @return string
     */
    protected function jsMatcher($matches):string
    {
        $chr = $matches[0];
        if (strlen($chr) === 1) {
            return sprintf('\\x%02X', ord($chr));
        }
        $chr = $this->convertEncoding($chr, 'UTF-16BE', 'UTF-8');
        $hex = strtoupper(bin2hex($chr));
        if (strlen($hex) <= 4) {
            return sprintf('\\u%04s', $hex);
        }
        $highSurrogate = substr($hex, 0, 4);
        $lowSurrogate  = substr($hex, 4, 4);
        return sprintf('\\u%04s\\u%04s', $highSurrogate, $lowSurrogate);
    }
    
    /**
     * cssMatcher
     *
     * @param  mixed $matches
     * @return string
     */
    protected function cssMatcher($matches): string
    {
        $chr = $matches[0];
        if (strlen($chr) === 1) {
            $ord = ord($chr);
        } else {
            $chr = $this->convertEncoding($chr, 'UTF-32BE', 'UTF-8');
            $ord = hexdec(bin2hex($chr));
        }
        return sprintf('\\%X ', $ord);
    }
    
    /**
     * toUtf8
     *
     * @param  mixed $string
     * @return array|string
     */
    protected function toUtf8($string)
    {
        if ($this->getEncoding() === 'utf-8') {
            $result = $string;
        } else {
            $result = $this->convertEncoding($string, 'UTF-8', $this->getEncoding());
        }

        if (! $this->isUtf8($result)) {
            throw new RuntimeException(
                sprintf('String to be escaped was not valid UTF-8 or could not be converted: %s', $result)
            );
        }

        return $result;
    }
     
    /**
     * fromUtf8
     *
     * @param  mixed $string
     * @return array|string
     */
    protected function fromUtf8($string)
    {
        if ($this->getEncoding() === 'utf-8') {
            return $string;
        }

        return $this->convertEncoding($string, $this->getEncoding(), 'UTF-8');
    }
    
       
    /**
     * isUtf8
     *
     * @param  mixed $string
     * @return bool
     */
    protected function isUtf8($string): bool
    {
        return $string === '' || preg_match('/^./su', $string);
    }
    
    /**
     * convertEncoding
     *
     * @param  mixed $string
     * @param  mixed $to
     * @param  mixed $from
     * @return array|string
     */
    protected function convertEncoding($string, $to, $from)
    {
        $result = mb_convert_encoding($string, $to, $from);

        if ($result === false) {
            return ''; // return non-fatal blank string on encoding errors from users
        }

        return $result;
    }
}