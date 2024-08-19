<?php

declare(strict_types=1);

namespace App\Model\Forms;

use Faster\Component\Enums\DataTypeEnum;
use Faster\Component\Enums\RuleEnum;
use Faster\Model\FormModel;

class TestimoniForm extends FormModel
{
    public function __construct(bool $isEdit = false)
    {
        parent::__construct('formTestimoni', 'pesan', $isEdit);
        $this->addProperty('pesan', DataTypeEnum::STRING, [RuleEnum::MIN_LENGTH, 3], 'Pesan');
        $this->addProperty('rating', DataTypeEnum::INT, [[RuleEnum::MIN, 1], [RuleEnum::MAX, 5]], 'Rating');
        $this->addProperty('captcha', DataTypeEnum::STRING, RuleEnum::CAPTCHA, 'Kode Keamanan');
    }
}
