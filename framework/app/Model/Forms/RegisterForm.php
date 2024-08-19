<?php

declare(strict_types=1);

namespace App\Model\Forms;

use Faster\Component\Enums\DataTypeEnum;
use Faster\Component\Enums\RuleEnum;
use Faster\Model\FormModel;

class RegisterForm extends FormModel
{
    public function __construct(bool $isEdit = false)
    {
        parent::__construct('formRegister', 'nama', $isEdit);
        $this->addProperty('nama', DataTypeEnum::STRING, [RuleEnum::MIN_LENGTH, 3], 'Nama');
        $this->addProperty('email', DataTypeEnum::STRING, RuleEnum::EMAIL, 'Email');
        $this->addProperty('nip', DataTypeEnum::STRING, [[RuleEnum::LENGTH, 18], RuleEnum::NUMERIC], 'NIP');
        $this->addProperty('jabatan', DataTypeEnum::STRING, [[RuleEnum::MIN_LENGTH, 3]], 'Jabatan');
        $this->addProperty('instansi', DataTypeEnum::STRING, [RuleEnum::MIN_LENGTH, 3], 'Instansi');
        $this->addProperty('tingkat', DataTypeEnum::INT, RuleEnum::REQUIRED, 'Tingkat');
        $this->addProperty('nomor_wa', DataTypeEnum::STRING, [[RuleEnum::MIN_LENGTH, 10], RuleEnum::NUMERIC], 'Nomor HP');
        $this->addProperty('password', DataTypeEnum::STRING, [RuleEnum::MIN_LENGTH, 6], 'Password');
        $this->addProperty('repassword', DataTypeEnum::STRING, [RuleEnum::MATCH_FIELD, 'password'], 'Ulangi Password');
        $this->addProperty('captcha', DataTypeEnum::STRING, RuleEnum::CAPTCHA, 'Kode Keamanan');
    }
}
