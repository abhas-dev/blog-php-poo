<?php

namespace App\Forms;

class RegisterForm extends Form
{
    /** @var string  */
    protected string $username;

    /** @var string  */
    protected string $email;

    /** @var string  */
    protected string $password;

    /** @var string  */
    public string $confirmationPassword;

    /** @var string  */
    protected string $firstname;

    /** @var string  */
    protected string $lastname;

    /** @var string|null */
    protected ?string $avatar = '';


    public static function metadata(): array
    {
        return [
            "table"            => "User",
            "primaryKey"       => "id",
            "columns"          => [
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
                "avatar"        => [
                    "type"     => "string",
                    "property" => "avatar"
                ]
            ]
        ];
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
    public function getConfirmationPassword(): string
    {
        return $this->confirmationPassword;
    }

    /**
     * @param string $confirmationPassword
     */
    public function setConfirmationPassword(string $confirmationPassword): void
    {
        $this->confirmationPassword = $confirmationPassword;
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
