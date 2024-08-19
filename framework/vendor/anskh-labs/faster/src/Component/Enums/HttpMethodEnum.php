<?php

declare(strict_types=1);

namespace Faster\Component\Enums;

/**
 * HttpMethodEnum
 * -----------
 * HttpMethodEnum
 *
 * @author Khaerul Anas <khaerulanas@live.com>
 * @since 1.0.0
 * @package Faster\Component\Enums
 */
class HttpMethodEnum extends BaseEnum
{
    public const GET = "GET";
    public const POST = "POST";
    public const PATCH = "PATCH";
    public const DELETE  = "DELETE";
    public const PUT = "PUT";
    public const HEAD = "HEAD";
    public const CONNECT = "CONNECT";
    public const OPTIONS = "OPTIONS";
    public const TRACE = "TRACE";
}
