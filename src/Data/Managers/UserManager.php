<?php

namespace App\Data\Managers;

use App\Data\Models\Model;
use App\Data\Models\UserModel;

class UserManager extends Manager
{
    public function getModelName()
    {
        return UserModel::class;
    }

    public function save(Model &$model)
    {
        $model->encryptPassword();
        $model->setStatus($model::STATUS_INACTIVE);
        return parent::save($model);
    }
}
