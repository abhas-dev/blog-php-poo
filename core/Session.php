<?php

namespace App;

class Session
{
    protected const FLASH_KEY = 'flash_messages';
    protected array $session;

    public function __construct()
    {
        session_start();

        $this->session = $_SESSION;

        if($_SESSION['token'] == null)
        {
            $_SESSION['token'] = bin2hex(random_bytes(32));
        }
//        $flashMessages = $_SESSION[self::FLASH_KEY] ?? [];
//        foreach ($flashMessages as $key => $flashMessage)
//        {
//            // Mark to be removed
//            $flashMessage['remove'] = true;
//        }
//
//        $_SESSION[self::FLASH_KEY] = $flashMessages;
    }

    public static function setUserSession($user)
    {
        $_SESSION['auth'] = ['id' => $user->getId(), 'email' => $user->getEmail()];
    }

    public static function setFlash($key, $message)
    {
        $_SESSION[self::FLASH_KEY][$key] = $message;
    }

    public function getFlash($key)
    {

    }
    public static function setCsrfToken()
    {
        if($_SESSION['token'] === null)
        {
            $_SESSION['token'] = bin2hex(random_bytes(32));

        }
    }
}