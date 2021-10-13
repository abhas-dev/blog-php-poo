<?php

namespace App\Forms;

class CommentForm extends Form
{
    /** @var string  */
    protected string $content;

    /** @var string  */
    protected ?string $author = null;

    public static function metadata(): array
    {
        return [
            "columns" => [
                "content"      => [
                    "type"     => "string",
                    "property" => "content"
                ],
                "author"      => [
                    "type"     => "string",
                    "property" => "author"
                ]
            ]
        ];
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
     * @return string
     */
    public function getAuthor(): string
    {
        return $this->author;
    }

    /**
     * @param string $author
     */
    public function setAuthor(string $author): void
    {
        $this->author = $author;
    }

    public function rules(): array
    {
        return [
            "author" => [self::RULE_REQUIRED],
            "content" => [self::RULE_REQUIRED]
        ];
    }
}
