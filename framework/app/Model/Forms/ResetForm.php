<?php

declare(strict_types=1);

namespace App\Model\Forms;

use Faster\Component\Enums\DataTypeEnum;
use Faster\Component\Enums\RuleEnum;
use Faster\Model\FormModel;

class ResetForm extends FormModel
{
    public function __construct(bool $isEdit = false)
    {
        parent::__construct('formReset', 'email', $isEdit);
        $this->addProperty('email', DataTypeEnum::STRING, RuleEnum::EMAIL, 'Email');
        $this->addProperty('captcha', DataTypeEnum::STRING, RuleEnum::CAPTCHA, 'Kode keamanan');
    }
}
