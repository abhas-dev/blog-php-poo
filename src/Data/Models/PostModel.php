<?php

namespace App\Data\Models;

use PDO;

class PostModel extends Model
{
    /** @var int|null */
    protected ?int $id = null;

    /** @var string */
    protected string $introduction;

    /** @var string */
    protected string $title;

    /** @var string  */
    protected string $content;

    /** @var int  */
    protected int $idUser;

    /** @var array|null */
    protected ?array $tags = [];

    /** @var array  */
    protected array $comments = [];

    /** @var \DateTimeImmutable|null */
    protected ?\DateTimeImmutable $createdAt = null;

    /** @var \DateTimeImmutable|null */
    protected ?\DateTimeImmutable $updatedAt = null;

    /**
     * @return array
     */
    public static function metadata(): array
    {
        return [
            "table"            => "Post",
            "primaryKey"       => "id",
            "columns"          => [
                "id"           => [
                    "type"     => "integer",
                    "property" => "id"
                ],
                "title"        => [
                    "type"     => "string",
                    "property" => "title"
                ],
                "introduction"        => [
                    "type"     => "string",
                    "property" => "introduction"
                ],
                "content"      => [
                    "type"     => "string",
                    "property" => "content"
                ],
                "id_user"      => [
                    "type"     => "integer",
                    "property" => "idUser"
                ],
                "created_at"        => [
                    "type"     => "datetime",
                    "property" => "createdAt"
                ],
                "updated_at"        => [
                    "type"     => "datetime",
                    "property" => "updatedAt"
                ]
            ]
        ];
    }

    /**
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return PostModel
     */
    public function setId(int $id): PostModel
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return PostModel
     */
    public function setTitle(string $title): PostModel
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @param string $content
     * @return PostModel
     */
    public function setContent(string $content): PostModel
    {
        $this->content = htmlspecialchars_decode($content);
        return $this;
    }

    /**
     * @return array
     */
    public function getTags(): array
    {
        return $this->tags;
    }

    /**
     * @param array $tags
     */
    public function setTags(array $tags): void
    {
        $this->tags = $tags;
    }

    /**
     * @return string
     */
    public function getIdUser(): int|string
    {
        return $this->idUser;
    }

    /**
     * @param string $idUser
     */
    public function setIdUser(int|string $idUser): void
    {
        $this->idUser = $idUser;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTimeImmutable $createdAt
     * @return PostModel
     */
    public function setCreatedAt(\DateTimeImmutable $createdAt): PostModel
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getIntroduction(): ?string
    {
        return $this->introduction;
    }

    /**
     * @param string $introduction
     */
    public function setIntroduction(string $introduction): void
    {
        $this->introduction = $introduction;
    }

    /**
     * @return array
     */
    public function getComments(): array
    {
        return $this->comments;
    }

    /**
     * @param CommentModel $comments
     */
    public function setComments(CommentModel $comments): void
    {
        $this->comments[] = $comments;
    }

    /**
     * @return \DateTimeImmutable|null
     */
    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTimeImmutable|null $updatedAt
     */
    public function setUpdatedAt(?\DateTimeImmutable $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }
}
