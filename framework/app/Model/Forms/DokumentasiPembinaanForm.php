<?php

declare(strict_types=1);

namespace App\Model\Forms;

use Faster\Component\Enums\DataTypeEnum;
use Faster\Component\Enums\RuleEnum;
use Faster\Model\FormModel;

class DokumentasiPembinaanForm extends FormModel
{
    public function __construct(bool $isEdit = false)
    {
        parent::__construct('formDokumentasiPembinaan', 'judul', $isEdit);
        $this->addProperty('judul', DataTypeEnum::STRING, [RuleEnum::MIN_LENGTH, 3], 'Judul');
        $this->addProperty('berita', DataTypeEnum::STRING, [RuleEnum::MIN_LENGTH, 3], 'Isi Berita');
        $this->addProperty('is_active', DataTypeEnum::INT, $isEdit ? [RuleEnum::IN_LIST, [0,1]] : null, 'Aktif');
        $this->addProperty('gambar', DataTypeEnum::STRING, null, 'File Gambar');
        $this->addProperty('permintaan_id', DataTypeEnum::INT, null, 'Id Permintaan Pembinaan');
        $this->addProperty('tanggal', DataTypeEnum::STRING, RuleEnum::DATE, 'Tanggal');
    }
}
