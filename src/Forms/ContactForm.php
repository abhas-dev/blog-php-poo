<?php

namespace App\Forms;

class ContactForm extends Form
{
    protected string $name;
    protected string $email;
    protected ?string $subject = '';
    protected string $message;

    public static function metadata(): array
    {
        return [
            "columns"          => [
                "name"           => [
                    "type"     => "string",
                    "property" => "name"
                ],
                "email"           => [
                    "type"     => "string",
                    "property" => "email"
                ],
                "subject"      => [
                    "type"     => "string",
                    "property" => "subject"
                ],
                "message"           => [
                    "type"     => "string",
                    "property" => "message"
                ],
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
     */
    public function setName(string $name): void
    {
        $this->name = $name;
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
     * @return string|null
     */
    public function getSubject(): ?string
    {
        return $this->subject;
    }

    /**
     * @param string|null $subject
     */
    public function setSubject(?string $subject): void
    {
        $this->subject = $subject;
    }


    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @param string $message
     */
    public function setMessage(string $message): void
    {
        $this->message = $message;
    }

    public function rules(): array
    {
        return [
            'name' =>[self::RULE_REQUIRED],
            'email' => [self::RULE_REQUIRED, self::RULE_EMAIL],
            'message' => [self::RULE_REQUIRED],
        ];
    }
}