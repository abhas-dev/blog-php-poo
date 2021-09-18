<?php

namespace App\Data\Managers;

use App\Data\Models\CommentModel;

class CommentManager extends Manager
{
    public function getModelName()
    {
        return CommentModel::class;
    }
}
