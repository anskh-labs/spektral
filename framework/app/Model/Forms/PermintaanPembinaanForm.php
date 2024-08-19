<?php

declare(strict_types=1);

namespace App\Model\Forms;

use Faster\Component\Enums\DataTypeEnum;
use Faster\Component\Enums\RuleEnum;
use Faster\Model\FormModel;

class PermintaanPembinaanForm extends FormModel
{
    public function __construct(bool $isEdit = false)
    {
        parent::__construct('formPermintaanPembinaan', 'deskripsi', $isEdit);
        $this->addProperty('produsen_data', DataTypeEnum::INT, RuleEnum::NUMERIC, 'Apakah instansi termasuk produsen data?');
        $this->addProperty('deskripsi', DataTypeEnum::STRING, [RuleEnum::MIN_LENGTH, 5], 'Deskripsi pembinaan yang diperlukan');
        $this->addProperty('model_pembinaan', DataTypeEnum::INT, RuleEnum::NUMERIC, 'Jenis media/model pembinaan');
        $this->addProperty('surat', DataTypeEnum::STRING, null, 'Surat pengantar');
        $this->addProperty('tanggal', DataTypeEnum::STRING, RuleEnum::DATE, 'Tanggal');
        $this->addProperty('lokasi', DataTypeEnum::STRING, RuleEnum::REQUIRED, 'Tempat');
        $this->addProperty('waktu', DataTypeEnum::STRING, RuleEnum::TIME, 'Waktu');
        $this->addProperty('nama_pic', DataTypeEnum::STRING, [RuleEnum::MIN_LENGTH, 3], 'Nama PIC');
        $this->addProperty('email_pic', DataTypeEnum::STRING, RuleEnum::EMAIL, 'Email PIC');
        $this->addProperty('hp_pic', DataTypeEnum::STRING, [[RuleEnum::MIN_LENGTH, 10], RuleEnum::NUMERIC], 'Nomor HP PIC');
    }
}
