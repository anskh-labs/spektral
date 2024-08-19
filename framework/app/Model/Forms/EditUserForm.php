<?php

declare(strict_types=1);

namespace App\Model\Forms;

use Faster\Component\Enums\DataTypeEnum;
use Faster\Component\Enums\RuleEnum;
use Faster\Model\FormModel;

class EditUserForm extends FormModel
{
    public function __construct(bool $isEdit = false)
    {
        parent::__construct('formEditUser', 'role', $isEdit);
        $this->addProperty('is_active', DataTypeEnum::INT, [RuleEnum::IN_LIST, [0,1]], 'Status');
        $this->addProperty('role', DataTypeEnum::STRING , RuleEnum::REQUIRED, 'Role');
    }
}
