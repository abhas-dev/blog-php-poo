<?php

namespace App\Data\Models;

class LoginModel extends Model
{
    /** @var string  */
    protected string $email;

    /** @var string  */
    protected string $password;

    protected \DateTimeImmutable $createdAt;

    public static function metadata(): array
    {
        return [
            "table"            => "User",
            "primaryKey"       => "id",
            "columns"          => [
                "email"           => [
                    "type"     => "string",
                    "property" => "email"
                ],
                "password"      => [
                    "type"     => "string",
                    "property" => "password"
                ]
            ]
        ];
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
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

    public function getPropsToArray() {
        return get_object_vars($this);
    }

    public function rules(): array
    {
        return [
            'email' => [self::RULE_REQUIRED, self::RULE_EMAIL],
            'password' => [self::RULE_REQUIRED]
        ];
    }

}
