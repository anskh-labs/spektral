<?php

declare(strict_types=1);

namespace Faster\Html;

use Faster\Helper\Html;
use Faster\Model\FormModel;

/**
 * Input
 * -----------
 * Input
 *
 * @author Khaerul Anas <khaerulanas@live.com>
 * @since 1.0.0
 * @package Faster\Html
 */
class Input
{
    const TYPE_TEXT = 'text';
    const TYPE_EMAIL = 'email';
    const TYPE_PASSWORD = 'password';
    const TYPE_NUMBER = 'number';
    const TYPE_DATE = 'date';
    const TYPE_TIME = 'time';
    const TYPE_TEL = 'tel';
    const TYPE_HIDDEN = 'hidden';

    public string $type;

    /**
     * __construct
     *
     * @param  FormModel $model
     * @param  string $attribute
     * @param  array $options
     * @return void
     */
    public function __construct(private FormModel $model, private string $attribute, private array $options = [])
    {
        $this->type = self::TYPE_TEXT;
    }

    /**
     * __toString
     *
     * @return string
     */
    public function __toString(): string
    {
        $this->options['value'] = $this->model->getProperty($this->attribute, '');
        switch ($this->type) {
            case self::TYPE_HIDDEN:
                return Html::input($this->attribute, $this->type, $this->options);
            default:
                if ($this->model->hasError($this->attribute)) {
                    $this->options['class'] = isset($this->options['class']) ? $this->options['class'] . ' is-invalid' : 'is-invalid';
                }
                $html = Html::input($this->attribute, $this->type, $this->options);
                if ($this->model->hasError($this->attribute)) {
                    $html .= Html::tag('div', $this->model->firstError($this->attribute), ['class' => 'invalid-feedback']);
                }
                return $html;
        }
    }

    /**
     * textField
     *
     * @return self
     */
    public function textField(): self
    {
        $this->type = self::TYPE_TEXT;
        return $this;
    }

    /**
     * hiddenField
     *
     * @return self
     */
    public function hiddenField(): self
    {
        $this->type = self::TYPE_HIDDEN;
        return $this;
    }

    /**
     * emailField
     *
     * @return self
     */
    public function emailField(): self
    {
        $this->type = self::TYPE_EMAIL;
        return $this;
    }

    /**
     * passField
     *
     * @return self
     */
    public function passField(): self
    {
        $this->type = self::TYPE_PASSWORD;
        return $this;
    }

    /**
     * numField
     *
     * @return self
     */
    public function numField(): self
    {
        $this->type = self::TYPE_NUMBER;
        return $this;
    }

    /**
     * dateField
     *
     * @return self
     */
    public function dateField(): self
    {
        $this->type = self::TYPE_DATE;
        return $this;
    }

    /**
     * timeField
     *
     * @return self
     */
    public function timeField(): self
    {
        $this->type = self::TYPE_TIME;
        return $this;
    }

    /**
     * telField
     *
     * @return self
     */
    public function telField(): self
    {
        $this->type = self::TYPE_TEL;
        return $this;
    }
}
