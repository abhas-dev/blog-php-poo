<?php

namespace App\Data\Managers;

use App\Data\Models\CommentModel;
use App\Data\Models\PostModel;

class PostManager extends Manager
{
    public function __construct()
    {
        parent::__construct();
        $this->table = "post";
    }

    public function getModelName(): string
    {
        return PostModel::class;
    }

//    public function findPostBySlug(string $slug): self
//    {
//        $sql = "SELECT * FROM $this->table WHERE slug = ?";
//        $query = $this->createQuery($sql, [$slug]);
//        $data = $query->fetchObject();
//        return (new $this->modelName)->hydrate($data);
//    }

    public function findPostBySlug(int $id): PostModel
    {
        $sql = "SELECT * FROM $this->table WHERE id = ?";
        $query = $this->createQuery($sql, [$id]);
        $data = $query->fetchObject();
        return (new $this->modelName)->hydrate($data);
    }

    public function findPostBySlugWithValidatedComments(int $id): PostModel
    {
        $post = $this->findPostBySlug($id);
        $sql = "SELECT `id`, `content`, `is_approuved`,`created_at`,`id_post` FROM `comment` WHERE id_post = ?";
        $query = $this->createQuery($sql, [$id]);
        $data = $query->fetchAll();
        if ($data){
            foreach ($data as $comment){
                $post->setComments((new CommentModel)->hydrate($comment));
            }
        }

        return $post;
    }
}