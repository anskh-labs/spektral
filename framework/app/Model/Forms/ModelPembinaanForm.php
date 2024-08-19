<?php

declare(strict_types=1);

namespace App\Model\Forms;

use Faster\Component\Enums\DataTypeEnum;
use Faster\Component\Enums\RuleEnum;
use Faster\Model\FormModel;

class ModelPembinaanForm extends FormModel
{
    public function __construct(bool $isEdit = false)
    {
        parent::__construct('formModelPembinaan', $isEdit ? 'nama' : 'id', $isEdit);
        $this->addProperty('id', DataTypeEnum::INT, [RuleEnum::REQUIRED, RuleEnum::NUMERIC], 'Id Model Pembinaan');
        $this->addProperty('nama', DataTypeEnum::STRING, [RuleEnum::MIN_LENGTH, 3], 'Nama Model Pembinaan');
    }
}
