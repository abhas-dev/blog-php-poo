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
        $tags = $this->getTags($id);
        $post->setTags($tags);
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

    public function getTags(int $id)
    {
        $sql = "
                SELECT `t`.* from `tag` t
                INNER JOIN  `post_tag` `pt` ON pt.`tag_id` = `t`.`id`
                INNER  JOIN `post` p ON `pt`.`post_id` = `p`.`id`
                WHERE p.id = ?";
        $query = $this->createQuery($sql, [$id]);
        return $query->fetchAll();
    }

}