<?php

namespace App\Data\Models;

class TagModel extends Model
{
    /** @var string  */
    protected string $name;

    public static function metadata(): array
    {
        return [
            "table"            => "Tag",
            "primaryKey"       => "id",
            "columns"          => [
                "name"      => [
                    "type"     => "string",
                    "property" => "name"
                ]
            ]
        ];
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return TagModel
     */
    public function setName(string $name): TagModel
    {
        $this->name = $name;
        return $this;
    }
}