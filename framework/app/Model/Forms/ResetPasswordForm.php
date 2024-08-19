<?php

declare(strict_types=1);

namespace App\Model\Forms;

use Faster\Component\Enums\DataTypeEnum;
use Faster\Component\Enums\RuleEnum;
use Faster\Model\FormModel;

class ResetPasswordForm extends FormModel
{
    public function __construct(bool $isEdit = false)
    {
        parent::__construct('formResetPassword', 'password', $isEdit);
        $this->addProperty('password', DataTypeEnum::STRING, [RuleEnum::MIN_LENGTH, 6], 'Password Baru');
        $this->addProperty('repassword', DataTypeEnum::STRING, [RuleEnum::MATCH_FIELD, 'password'], 'Ulangi Password Baru');
        $this->addProperty('captcha', DataTypeEnum::STRING, RuleEnum::CAPTCHA, 'Kode keamanan');
    }
}
