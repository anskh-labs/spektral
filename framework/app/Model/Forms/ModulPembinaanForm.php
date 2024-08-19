<?php

declare(strict_types=1);

namespace App\Model\Forms;

use Faster\Component\Enums\DataTypeEnum;
use Faster\Component\Enums\RuleEnum;
use Faster\Model\FormModel;

class ModulPembinaanForm extends FormModel
{
    public function __construct(bool $isEdit = false)
    {
        parent::__construct('formModulPembinaan', 'nama', $isEdit);
        $this->addProperty('nama', DataTypeEnum::STRING, [RuleEnum::MIN_LENGTH, 3], 'Nama');
        $this->addProperty('deskripsi', DataTypeEnum::STRING, [RuleEnum::MIN_LENGTH, 3], 'Deskripsi');
        $this->addProperty('kategori', DataTypeEnum::INT, RuleEnum::NUMERIC, 'Kategori');
        $this->addProperty('link', DataTypeEnum::STRING, null, 'File');
        $this->addProperty('is_active', DataTypeEnum::INT, [RuleEnum::IN_LIST, [0,1]], 'Status');
    }
}
