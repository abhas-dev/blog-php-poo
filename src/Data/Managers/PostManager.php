<?php

namespace App\Data\Managers;

use App\Data\Models\PostModel;

class PostManager extends Manager
{
    public function __construct()
    {
        parent::__construct();
        $this->table = "posts";
    }

    public function getModelName(): string
    {
        return PostModel::class;
    }
}