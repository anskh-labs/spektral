<?php

declare(strict_types=1);

namespace Faster\Http\Session;

/**
 * SessionInterface
 * -----------
 * SessionInterface
 *
 * @author Khaerul Anas <khaerulanas@live.com>
 * @since 1.0.0
 * @package Faster\Http\Session
 */
interface SessionInterface
{
    /**
     * set
     *
     * @param  string $property
     * @param  mixed $value
     * @return void
     */
    public function set(string $property, $value): void;
    /**
     * csrfToken
     *
     * @param  string $name
     * @param  bool $generate
     * @return string
     */
    public function csrfToken(string $name, bool $generate = true): string;
    /**
     * validateCsrfToken
     *
     * @param  string $name
     * @param  string|null $token
     * @return bool
     */
    public function validateCsrfToken(string $name, string|null $token): bool;    
    /**
     * captcha
     *
     * @param  string $formName
     * @param  int $length
     * @param  bool $generate
     * @return string
     */
    public function captcha(string $formName, int $length = 6, bool $generate = true): string;
    /**
     * get
     *
     * @param  string|null $property
     * @param  mixed $defaultValue
     * @return mixed
     */
    public function get(string|null $property = null, $defaultValue = null);
    /**
     * validateCaptcha
     *
     * @param  string $formName
     * @param  string|null $captcha
     * @return bool
     */
    public function validateCaptcha(string $formName, string|null $captcha): bool;
    /**
     * has
     *
     * @param  string|null $property
     * @return bool
     */
    public function has(string|null $property = null): bool;

    /**
     * unset
     *
     * @param  string|null $property
     * @return mixed
     */
    public function unset(string|null $property = null);

    /**
     * addFlashInfo
     *
     * @param  string $message
     * @return void
     */
    public function addFlashInfo(string $message): void;

    /**
     * flashInfo
     *
     * @return FlashMessage|null
     */
    public function flashInfo(): FlashMessage|null;
    /**
     * addFlashError
     *
     * @param  string $message
     * @return void
     */
    public function addFlashError(string $message): void;
    /**
     * flashError
     *
     * @return FlashMessage|null
     */
    public function flashError(): FlashMessage|null;
    /**
     * addFlashWarning
     *
     * @param  string $message
     * @return void
     */
    public function addFlashWarning(string $message): void;
    /**
     * flashWarning
     *
     * @return FlashMessage|null
     */
    public function flashWarning(): FlashMessage|null;
    /**
     * addFlashSuccess
     *
     * @param  string $message
     * @return void
     */
    public function addFlashSuccess(string $message): void;
    /**
     * flashSuccess
     *
     * @return FlashMessage|null
     */
    public function flashSuccess(): FlashMessage|null;

    /**
     * addFlash
     *
     * @param  string $type
     * @param  string $message
     * @return void
     */
    public function addFlash(string $type, string $message): void;

    /**
     * flash
     *
     * @param  string|null $type
     * @return FlashMessage|array|null
     */
    public function flash(string|null $type = null);

    /**
     * hasFlash
     *
     * @param  string|null $type
     * @return bool
     */
    public function hasFlash(string|null $type = null): bool;

    /**
     * hasFlashSuccess
     *
     * @return bool
     */
    public function hasFlashSuccess(): bool;
    /**
     * hasFlashError
     *
     * @return bool
     */
    public function hasFlashError(): bool;
    /**
     * hasFlashWarning
     *
     * @return bool
     */
    public function hasFlashWarning(): bool;
    /**
     * hasFlashInfo
     *
     * @return bool
     */
    public function hasFlashInfo(): bool;
}
