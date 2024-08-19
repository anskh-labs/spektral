<?php

declare(strict_types=1);

namespace App\Model\Forms;

use Faster\Component\Enums\DataTypeEnum;
use Faster\Component\Enums\RuleEnum;
use Faster\Model\FormModel;

class GsbpmForm extends FormModel
{
    public function __construct(bool $isEdit = false)
    {
        parent::__construct('formGsbpm', 'judul', $isEdit);
        $this->addProperty('tahapan', DataTypeEnum::STRING, null, 'Tahapan');
        $this->addProperty('isi', DataTypeEnum::STRING, [RuleEnum::MIN_LENGTH, 20], 'Isi');
        $this->addProperty('gambar', DataTypeEnum::STRING, null, 'File Gambar');
        $this->addProperty('link', DataTypeEnum::STRING, null, 'File PDF');
    }
}
