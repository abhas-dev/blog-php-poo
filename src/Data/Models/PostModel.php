<?php

namespace App\Data\Models;

use PDO;

class PostModel extends Model
{
    /** @var int|null */
    private ?int $id = null;

    /** @var string|null  */
    private ?string $introduction = '';

    /** @var string|null  */
    private ?string $slug = '';

    /** @var string */
    private string $title;

    /** @var string  */
    private string $content;

    /** @var string  */
    private int $idUser;

    /** @var array  */
    private array $tag = [];

    /** @var array  */
    private array $comments = [];

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
                "slug"        => [
                    "type"     => "string",
                    "property" => "slug"
                ],
                "content"      => [
                    "type"     => "string",
                    "property" => "content"
                ],
                "id_user"      => [
                    "type"     => "integer",
                    "property" => "idUser"
                ],
                "tag"          => [
                    "type"     => "array",
                    "property" => "tag"
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
        $this->content = $content;
        return $this;
    }

    /**
     * @return array
     */
    public function getTag(): array
    {
        return $this->tag;
    }

    /**
     * @param array $tag
     */
    public function setTag(array $tag): void
    {
        $this->tag = $tag;
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

    public function rules(): array
    {
        // TODO: Implement rules() method.

        return true;
    }

    /**
     * @return string|null
     */
    public function getIntroduction(): ?string
    {
        return $this->introduction;
    }

    /**
     * @param string|null $introduction
     */
    public function setIntroduction(?string $introduction): void
    {
        $this->introduction = $introduction;
    }

    /**
     * @return string|null
     */
    public function getSlug(): ?string
    {
        return $this->slug;
    }

    /**
     * @param string|null $slug
     */
    public function setSlug(?string $slug): void
    {
        $this->slug = $slug;
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

    public function getAuthorName()
    {
        // appel a userMamanager pour recuperer l'user par rapport a l'id
        return "test";
    }

    public function getTags()
    {

    }


}