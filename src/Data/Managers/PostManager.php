<?php

namespace App\Data\Managers;

class PostManager extends Manager
{
    public function __construct()
    {
        parent::__construct();
        $this->table = "posts";
    }
}