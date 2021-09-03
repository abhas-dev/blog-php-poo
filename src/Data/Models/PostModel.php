<?php

namespace App\Data\Models;

use PDO;

class PostModel extends Model
{
    /** @var int|null */
    private ?int $id = null;

    /** @var string */
    private string $title;

    /** @var string  */
    private string $content;

    /** @var \DateTimeImmutable|null */
    protected ?\DateTimeImmutable $createdAt = null;

    /**
     * @return array
     */
    public static function metadata(): array
    {
        return [
            "table"            => "posts",
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
                "content"      => [
                    "type"     => "string",
                    "property" => "content"
                ],
                "created_at"        => [
                    "type"     => "datetime",
                    "property" => "createdAt"
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
    }


}