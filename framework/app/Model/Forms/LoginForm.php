<?php

declare(strict_types=1);

namespace App\Model\Forms;

use Faster\Component\Enums\DataTypeEnum;
use Faster\Component\Enums\RuleEnum;
use Faster\Model\FormModel;

class LoginForm extends FormModel
{    
    /**
     * __construct
     *
     * @param  mixed $isEdit
     * @return void
     */
    public function __construct(bool $isEdit = false)
    {
        parent::__construct('formLogin', 'email', $isEdit);
        $this->addProperty('email', DataTypeEnum::STRING, RuleEnum::EMAIL, 'Email');
        $this->addProperty('password', DataTypeEnum::STRING, RuleEnum::REQUIRED, 'Password');
        $this->addProperty('captcha', DataTypeEnum::STRING, RuleEnum::CAPTCHA, 'Kode Keamanan');
    }
}
