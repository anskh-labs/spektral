<?php

declare(strict_types=1);

namespace Faster\Http\Session;

use Faster\Component\Enums\FlashMessageEnum;

/**
 * FlashMessage
 * -----------
 * FlashMessage
 *
 * @author Khaerul Anas <khaerulanas@live.com>
 * @since 1.0.0
 * @package Faster\Http\Session
 */
class FlashMessage
{
    private string $type;
    private array $messages;
    
    /**
     * __construct
     *
     * @param  string $type
     * @param  array $messages
     * @return void
     */
    public function __construct(string $type, array $messages = [])
    {
        $this->type = FlashMessageEnum::hasValue($type) ? $type : FlashMessageEnum::defaultType();
        $this->messages = $messages;        
    }

    /**
     * getMessages
     *
     * @return array
     */
    public function getMessages(): array
    {
        return $this->messages;
    }
    
    /**
     * addMessage
     *
     * @param  string $message
     * @return void
     */
    public function addMessage(string $message): void
    {
        $this->messages[] = $message;
    }
    
    /**
     * firstMessage
     *
     * @return string
     */
    public function firstMessage(): string
    {
        return $this->messages[0] ?? '';
    }

    /**
     * getType
     *
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * __toString
     *
     * @return void
     */
    public function __toString()
    {
        return implode(PHP_EOL, $this->messages);
    }
}
