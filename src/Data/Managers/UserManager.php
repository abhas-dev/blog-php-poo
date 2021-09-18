<?php

namespace App\Data\Managers;

use App\Application;
use App\Data\Models\LoginModel;
use App\Data\Models\Model;
use App\Data\Models\UserModel;
use App\Response;
use Exception;

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
        $model->setStatus($model::STATUS_INACTIVE);
        return parent::save($model);
    }

}