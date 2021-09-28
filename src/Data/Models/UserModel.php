<?php

namespace App\Data\Models;

class UserModel extends Model
{
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_DELETED = 2;

    /** @var int|null  */
    private ?int $id = null;

    /** @var string  */
    protected string $username;

    /** @var string  */
    protected string $email;

    /** @var string  */
    protected string $password;

    /** @var string  */
    protected string $firstname;

    /** @var string  */
    protected string $lastname;
//
//    /** @var string  */
//    protected string $role = "user";

    /** @var bool */
    protected bool $isActive = false;

    /** @var int|null  */
    protected ?int $isAdmin = 0;

    /** @var int  */
    protected int $status = self::STATUS_INACTIVE;

    /** @var string|null */
    protected ?string $avatar = null;

    /** @var \DateTimeImmutable|null */
    protected ?\DateTimeImmutable $createdAt = null;


    /**
     *
     *
     * @inheritDoc
     */
    public static function metadata(): array
    {
        return [
            "table"            => "User",
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
                "status"        => [
                    "type"     => "integer",
                    "property" => "status"
                ],
                "is_admin"        => [
                    "type"     => "integer",
                    "property" => "isAdmin"
                ],
                "avatar"        => [
                    "type"     => "string",
                    "property" => "avatar"
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
    public function getUsername(): ?string
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername(?string $username): void
    {
        $this->username = $username;
    }

    /**
     * @return string
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword(?string $password): void
    {
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    /**
     * @param string $firstname
     */
    public function setFirstname(?string $firstname): void
    {
        $this->firstname = $firstname;
    }

    /**
     * @return string
     */
    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    /**
     * @param string $lastname
     */
    public function setLastname(?string $lastname): void
    {
        $this->lastname = $lastname;
    }

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * @param int $status
     */
    public function setStatus(int $status): void
    {
        $this->status = $status;
    }

    /**
     * @return int
     */
    public function getIsAdmin(): int
    {
        return $this->isAdmin;
    }

    /**
     * @param int $isAdmin
     */
    public function setIsAdmin(int $isAdmin): void
    {
        $this->isAdmin = $isAdmin;
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
     * @return \DateTimeImmutable|null
     */
    public function getCreatedAt(): ?\DateTimeImmutable
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
}