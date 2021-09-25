<?php

namespace App\Data\Managers;

use App\Data\Models\CommentModel;

class CommentManager extends Manager
{
    public function __construct()
    {
        parent::__construct();
        $this->table = "comment";
    }

    public function getModelName()
    {
        return CommentModel::class;
    }


}