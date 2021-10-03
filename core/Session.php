<?php

namespace App;

class Session
{
    protected const FLASH_KEY = 'flash_messages';

    public function __construct()
    {
        session_start();

        if (!isset($_SESSION['token'])) {
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

    /**
     * @return array
     */
    public static function getSession(): array
    {
        return $_SESSION;
    }

    /**
     * @param $key
     * @param $value
     */
    public static function setSession($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    /**
     * @param $key
     */
    public static function unsetSession($key)
    {
        unset($_SESSION[$key]);
    }

    public static function setUserSession($user)
    {
        $_SESSION['auth'] = ['id' => $user->getId(), 'email' => $user->getEmail(), 'admin' => $user->getIsAdmin()];
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
        if ($_SESSION['token'] === null) {
            $_SESSION['token'] = bin2hex(random_bytes(32));
        }
    }
}
