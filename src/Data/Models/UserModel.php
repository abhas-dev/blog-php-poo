<?php

namespace App\Data\Models;

class UserModel extends Model
{
    /** @var int|null  */
    private ?int $id = null;

    /** @var string  */
    private string $username;

    /** @var string  */
    private string $email;

    /** @var string  */
    private string $password;

    /** @var string  */
    private string $firstname;

    /** @var string  */
    private string $lastname;

    /** @var string  */
    private string $role = "user";

    /** @var bool */
    private bool $isActive = false;

    /** @var string|null */
    private ?string $avatar = null;

    /** @var string  */
    private string $gender;

    /** @var \DateTimeImmutable|null */
    protected ?\DateTimeImmutable $createdAt = null;


    /**
     * @inheritDoc
     */
    public static function metadata(): array
    {
        return [
            "table"            => "users",
            "primaryKey"       => "id",
            "columns"          => [
                "id"           => [
                    "type"     => "integer",
                    "property" => "id"
                ],
                "username"        => [
                    "type"     => "string",
                    "property" => "username"
                ],
                "email"        => [
                    "type"     => "string",
                    "property" => "email"
                ],
                "password"        => [
                    "type"     => "string",
                    "property" => "password"
                ],
                "firstname"        => [
                    "type"     => "string",
                    "property" => "firstname"
                ],
                "lastname"        => [
                    "type"     => "string",
                    "property" => "lastname"
                ],
                "role"        => [
                    "type"     => "string",
                    "property" => "role"
                ],
                "gender"        => [
                    "type"     => "string",
                    "property" => "gender"
                ],
                "avatar"        => [
                    "type"     => "string",
                    "property" => "avatar"
                ],
                "is_active"      => [
                    "type"     => "string",
                    "property" => "isActive"
                ],
                "created_at"        => [
                    "type"     => "datetime",
                    "property" => "createdAt"
                ]
            ]
        ];

    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     */
    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername(string $username): void
    {
        $this->username = $username;
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
     * @return string
     */
    public function getFirstname(): string
    {
        return $this->firstname;
    }

    /**
     * @param string $firstname
     */
    public function setFirstname(string $firstname): void
    {
        $this->firstname = $firstname;
    }

    /**
     * @return string
     */
    public function getLastname(): string
    {
        return $this->lastname;
    }

    /**
     * @param string $lastname
     */
    public function setLastname(string $lastname): void
    {
        $this->lastname = $lastname;
    }

    /**
     * @return string
     */
    public function getRole(): string
    {
        return $this->role;
    }

    /**
     * @param string $role
     */
    public function setRole(string $role): void
    {
        $this->role = $role;
    }

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->isActive;
    }

    /**
     * @param bool $isActive
     */
    public function setIsActive(bool $isActive): void
    {
        $this->isActive = $isActive;
    }

    /**
     * @return string|null
     */
    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    /**
     * @param string|null $avatar
     */
    public function setAvatar(?string $avatar): void
    {
        $this->avatar = $avatar;
    }

    /**
     * @return string
     */
    public function getGender(): string
    {
        return $this->gender;
    }

    /**
     * @param string $gender
     */
    public function setGender(string $gender): void
    {
        $this->gender = $gender;
    }

    /**
     * @return \DateTimeImmutable|null
     */
    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTimeImmutable|null $createdAt
     */
    public function setCreatedAt(?\DateTimeImmutable $createdAt): void
    {
        $this->createdAt = $createdAt;
    }



}