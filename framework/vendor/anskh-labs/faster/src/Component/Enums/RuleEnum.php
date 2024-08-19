<?php

declare(strict_types=1);

namespace Faster\Component\Enums;

/**
 * RuleEnum
 * -----------
 * RuleEnum
 *
 * @author Khaerul Anas <khaerulanas@live.com>
 * @since 1.0.0
 * @package Faster\Component\Enums
 */
class RuleEnum extends BaseEnum
{
    public const REQUIRED = 'required';
    public const EMAIL = 'email';
    public const URL = 'url';
    public const IP = 'ip';
    public const LENGTH = 'length';
    public const MIN_LENGTH = 'min_length';
    public const MAX_LENGTH = 'max_length';
    public const MATCH_FIELD = 'match_field';
    public const NOT_MATCH_FIELD = 'not_match_field';
    public const MATCH = 'match';
    public const NOT_MATCH = 'not_match';
    public const CONTAINS = 'contains';
    public const NOT_CONTAINS = 'not_contains';
    public const STARTS_WITH = 'starts_with';
    public const ENDS_WITH = 'ends_with';
    public const NUMERIC = 'numeric';
    public const IN_LIST = 'in_list';
    public const IN_RANGE = 'in_range';
    public const MAX = 'max';
    public const MIN = 'min';
    public const DATE = 'date';
    public const TIME = 'time';
    public const CAPTCHA = 'captcha';
    public const PASSWORD = 'password';
}

