<?php

namespace App\Data\Managers;

use App\Data\Models\Model;
use App\Data\Models\UserModel;

class UserManager extends Manager
{
    public function __construct()
    {
        parent::__construct();
        $this->table = "user";
    }

    public function getModelName()
    {
        return UserModel::class;
    }

    public function save(Model &$model)
    {
        $model->encryptPassword();
        return parent::save($model);
    }
}
