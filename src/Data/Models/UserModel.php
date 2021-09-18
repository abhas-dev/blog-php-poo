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
    protected ?string $username = null;

    /** @var string  */
    protected ?string $email = null;

    /** @var string  */
    protected ?string $password = null;

    /** @var string  */
    public ?string $confirmationPassword = null;

    /** @var string  */
    protected ?string $firstname = null;

    /** @var string  */
    protected ?string $lastname = null;
//
//    /** @var string  */
//    protected string $role = "user";

    /** @var bool */
    protected bool $isActive = false;

    /** @var int  */
    protected int $status = self::STATUS_INACTIVE;

    /** @var string|null */
    protected ?string $avatar = null;

    /** @var string  */
    protected ?string $gender = null;

    /** @var \DateTimeImmutable|null */
    protected ?\DateTimeImmutable $createdAt = null;


    /**
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
                "confirmationPassword"        => [
                    "type"     => "string",
                    "property" => "confirmationPassword"
                ],
                "firstname"        => [
                    "type"     => "string",
                    "property" => "firstname"
                ],
                "lastname"        => [
                    "type"     => "string",
                    "property" => "lastname"
                ],
                "gender"        => [
                    "type"     => "string",
                    "property" => "gender"
                ],
                "status"        => [
                    "type"     => "int",
                    "property" => "status"
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
    public function getConfirmationPassword(): ?string
    {
        return $this->confirmationPassword;
    }

    /**
     * @param string $confirmationPassword
     */
    public function setConfirmationPassword(?string $confirmationPassword): void
    {
        $this->confirmationPassword = $confirmationPassword;
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
     * @return bool
     */
    public function getIsActive(): bool
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
    public function getGender(): ?string
    {
        return $this->gender;
    }

    /**
     * @param string $gender
     */
    public function setGender(?string $gender): void
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

    public function encryptPassword(): string
    {
        return $this->password = password_hash($this->password, PASSWORD_ARGON2I);
    }


    public function rules(): array
    {
        return [
            'username' => [self::RULE_REQUIRED, [self::RULE_MIN, 'min' => 4]],
            'email' => [self::RULE_REQUIRED, self::RULE_EMAIL, [self::RULE_UNIQUE, 'class' => self::class]],
            'firstname' => [self::RULE_REQUIRED],
            'lastname' => [self::RULE_REQUIRED],
            'password' => [self::RULE_REQUIRED, [self::RULE_MIN, 'min' => 8], [self::RULE_MAX, 'max' => 24]],
            'confirmationPassword' => [self::RULE_REQUIRED, [self::RULE_MATCH, 'match' => 'password']],
        ];
    }


}