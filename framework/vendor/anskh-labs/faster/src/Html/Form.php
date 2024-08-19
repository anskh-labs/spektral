<?php

declare(strict_types=1);

namespace Faster\Html;

use Faster\Helper\Html;
use Faster\Helper\Service;
use Faster\Model\FormModel;

/**
 * Form
 * -----------
 * Form
 *
 * @author Khaerul Anas <khaerulanas@live.com>
 * @since 1.0.0
 * @package Faster\Html
 */
class Form
{

    /**
     * __construct
     *
     * @param  FormModel|null $model
     * @return void
     */
    public function __construct(private FormModel|null $model = null)
    {
    }
    /**
     * begin
     *
     * @param  string $action
     * @param  string $method
     * @param  array $options
     * @return string
     */
    public function begin(string $action, string $method = 'POST', array $options = []): string
    {
        $html = Html::beginForm($action, $method, $options);
        if ($this->model->isCsrfEnabled()) {
            $token = Service::session()->csrfToken($this->model->getName());
            $html .= Html::input($this->model->csrfTokenName(), 'hidden', ['value' => $token]);
        }
        return $html;
    }

    /**
     * end
     *
     * @return string
     */
    public function end(): string
    {
        return Html::endForm();
    }
    /**
     * field
     *
     * @param  string $attribute
     * @param  array $options
     * @return Input
     */
    public function field(string $attribute, array $options = []): Input
    {
        return new Input($this->model, $attribute, $options);
    }
    /**
     * Generate captcha
     *
     * @param  array $options
     * @return string
     */
    public function captcha(array $options = []): string
    {
        // Generate captcha code
        $captcha_code  = Service::session()->captcha($this->model->getName());
        // Create captcha image
        $layer = \imagecreatetruecolor(100, 30);
        $captcha_bg = \imagecolorallocate($layer, 204, 204, 204);
        \imagefill($layer, 0, 0, $captcha_bg);
        $captcha_text_color = imagecolorallocate($layer, 51, 51, 255);
        \imagestring($layer, 5, 25, 7, $captcha_code, $captcha_text_color);
        \ob_start();
        // Output the image
        \imagejpeg($layer);
        // Free up memory
        \imagedestroy($layer);
        $binary = \ob_get_clean();
        return Html::img('data:image/jpeg;base64,' . \base64_encode($binary), $options);
    }
    /**
     * select
     *
     * @param  string $attribute
     * @param  array $labels
     * @param  array|null $values
     * @param  array $options
     * @return string
     */
    public function select(string $attribute, array $labels, array|null $values = null, array $options = []): string
    {
        $html = Html::beginSelect($attribute, $options);
        if (empty($values))
            $values = $labels;
        $count = count($labels);
        for ($i = 0; $i < $count; $i++) {
            $ops = ['value' => $values[$i]];
            if ($this->model->getProperty($attribute) == $values[$i])
                $ops[] = 'selected';
            $html .= Html::tag('option', $labels[$i], $ops);
        }
        $html .= Html::endSelect();
        if ($this->model->hasError($attribute)) {
            $html .= Html::tag('div', $this->model->firstError($attribute), ['class' => 'invalid-feedback']);
        }
        return $html;
    }

    /**
     * textArea
     *
     * @param  string $attribute
     * @param  array $options
     * @return string
     */
    public function textArea(string $attribute, array $options = []): string
    {
        $options['name'] = $attribute;
        if ($this->model->hasError($attribute)) {
            $options['class'] = isset($options['class']) ? $options['class'] . ' is-invalid' : 'is-invalid';
        }
        $html = Html::tag('textarea', $this->model->getProperty($attribute, ''), $options);
        if ($this->model->hasError($attribute)) {
            $html .= Html::tag('div', $this->model->firstError($attribute), ['class' => 'invalid-feedback']);
        }
        return $html;
    }

    /**
     * list
     *
     * @param  string $attribute
     * @param  array $data
     * @param  array $options
     * @return string
     */
    public function list(string $attribute, array $data, array $options = []): string
    {
        $options['list'] = 'datalistOptions_' . $attribute;
        $options['name'] = $attribute;
        $options['value'] = $this->model->getProperty($attribute, '');
        if ($this->model->hasError($attribute)) {
            $options['class'] = isset($options['class']) ? $options['class'] . ' is-invalid' : 'is-invalid';
        }
        $html = Html::beginTag('input', $options);
        $html .= Html::beginTag('datalist', ['id' => 'datalistOptions_' . $attribute]);
        foreach ($data as $d) {
            $html .= Html::beginTag('option', ['value' => $d]);
        }
        $html .= Html::endTag('datalist');
        if ($this->model->hasError($attribute)) {
            $html .= Html::tag('div', $this->model->firstError($attribute), ['class' => 'invalid-feedback']);
        }
        return $html;
    }
    /**
     * file
     *
     * @param  string $attribute
     * @param  array $options
     * @return string
     */
    public function file(string $attribute, array $options = []): string
    {
        if ($this->model->hasError($attribute)) {
            $options['class'] = isset($options['class']) ? $options['class'] . ' is-invalid' : 'is-invalid';
        }
        $html = '<input id="id_' . $attribute . '" name="' . $attribute . '" type="file" ' . attr_to_string($options) . '>' . PHP_EOL;
        if ($this->model->hasError($attribute)) {
            $html .= '<div class="invalid-feedback">' . $this->model->firstError($attribute) . '</div>' . PHP_EOL;
        }

        return $html;
    }
}
