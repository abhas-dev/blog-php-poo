<?php

namespace App\Forms;

class PostForm extends Form
{
    /** @var string */
    protected string $title;

    /** @var string  */
    protected string $content;

    public static function metadata(): array
    {
        return [
            "columns"          => [
                "title"           => [
                    "type"     => "string",
                    "property" => "title"
                ],
                "content"      => [
                    "type"     => "string",
                    "property" => "content"
                ]
            ]
        ];
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
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
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

    public function rules(): array
    {
        return [
            'title' => [self::RULE_REQUIRED, [self::RULE_MIN, 'min' => 5]],
            'content' => [self::RULE_REQUIRED, [self::RULE_MIN, 'min' => 100]]
        ];
    }
}