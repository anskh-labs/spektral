<?php

declare(strict_types=1);

namespace App\Model\Forms;

use Faster\Component\Enums\DataTypeEnum;
use Faster\Component\Enums\RuleEnum;
use Faster\Model\FormModel;

class PesanPermintaanForm extends FormModel
{
    public function __construct(bool $isEdit = false)
    {
        parent::__construct('formPesanPermintaan', 'pesan', $isEdit);
        $this->addProperty('pesan', DataTypeEnum::STRING, [RuleEnum::MIN_LENGTH, 3], 'Pesan');
    }
}
