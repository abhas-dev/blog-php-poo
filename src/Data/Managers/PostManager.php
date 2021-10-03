<?php

namespace App\Data\Managers;

use App\Data\Models\CommentModel;
use App\Data\Models\Model;
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
        $sql = "
                SELECT post.*, user.username author
                FROM $this->table
                INNER JOIN user ON post.id_user = user.id
                WHERE post.id = ?";
        $query = $this->createQuery($sql, [$id]);
        $data = $query->fetch();
        return (new PostModel())->hydrate($data);
    }

    public function findPostByIdWithValidateComment(int $id): PostModel
    {
        $post = $this->findPostBySlug($id);
        $tags = $this->getTags($id);
        $post->setTags($tags);
        $sql = "SELECT `id`, `content`, `username`,`is_approuved`,`created_at`,`id_post` FROM `comment` WHERE id_post = ? AND `is_approuved` = ?";
        $query = $this->createQuery($sql, [$id, 1]);
        $data = $query->fetchAll();
        if ($data) {
            foreach ($data as $comment) {
                $post->setComments((new CommentModel())->hydrate($comment));
            }
        } else {
            throw new \Exception('requete ratée');
        }

        return $post;
    }

    private function getTags(int $id)
    {
        $sql = "
                SELECT `t`.* from `tag` t
                INNER JOIN  `post_tag` `pt` ON pt.`tag_id` = `t`.`id`
                INNER  JOIN `post` p ON `pt`.`post_id` = `p`.`id`
                WHERE p.id = ?";
        $query = $this->createQuery($sql, [$id]);
        return $query->fetchAll();
    }


//    public function findPostByIdWithValidateComment(int $id): PostModel
//    {
//        $sql = "SELECT post.*, comment.*, user.username
//                FROM post
//                LEFT JOIN comment ON post.id = comment.id_post
//                LEFT JOIN user ON post.id_user = user.id
//                WHERE post.id = ?
//                AND comment.is_approuved = ?;";
//        $query = $this->createQuery($sql, [$id, 1]);
//        $data = $query->fetchAll();
////        var_dump($data);die();
//        if ($data) {
//            foreach ($data as $comment) {
//                $post->setComments((new CommentModel())->hydrate($comment));
//            }
//        }
//        else{
//            throw new \Exception('requete ratée');
//        }
//
//        $tags = $this->getTags($id);
//        $post->setTags($tags);
//
//        return $post;
//    }
}
