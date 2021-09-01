<?php

namespace App\Data\Managers;

use App\Data\Models\UserModel;

class UserManager extends Manager
{

    public function getModelName()
    {
        return UserModel::class;
    }
}