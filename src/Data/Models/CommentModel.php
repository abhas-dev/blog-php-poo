<?php

namespace App\Data\Models;

class CommentModel extends Model
{
    private ?int $id = null;

    private ?string $content = '';

    private bool $isApprouved;

    private ?int $idPost = null;

    private ?\DateTimeImmutable $createdAt = null;

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
                "content"      => [
                    "type"     => "string",
                    "property" => "content"
                ],
                "created_at"        => [
                    "type"     => "datetime",
                    "property" => "createdAt"
                ],
                "is_approuved"        => [
                    "type"     => "bool",
                    "property" => "isApprouved"
                ],
                "id_post"        => [
                    "type"     => "int",
                    "property" => "idPost"
                ]
            ]
        ];
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
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
     */
    public function setContent(string $content): void
    {
        $this->content = $content;
    }

    /**
     * @return bool
     */
    public function isApprouved(): bool
    {
        return $this->isApprouved;
    }

    /**
     * @param bool $isApprouved
     */
    public function setIsApprouved(bool $isApprouved): void
    {
        $this->isApprouved = $isApprouved;
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
     */
    public function setCreatedAt(\DateTimeImmutable $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function rules(): array
    {
        // TODO: Implement rules() method.

        return [];
    }

}
