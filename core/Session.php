<?php

namespace App;

class Session
{

    public function __construct()
    {
        session_start();

        if(!isset($_SESSION['token']))
        {
            $_SESSION['token'] = bin2hex(random_bytes(32));
        }
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
        $_SESSION['auth'] = ['id' => $user->getId(), 'email' => $user->getEmail(), 'username' => $user->getUsername(), 'admin' => $user->getIsAdmin()];
    }

    public static function setFlash($key, $message)
    {
        $_SESSION['flash_messages'][$key] = $message;
    }

    public function getFlash($key)
    {
        return $_SESSION['flash_messages'][$key];
    }

    public static function setCsrfToken()
    {
        if($_SESSION['token'] === null)
        {
            $_SESSION['token'] = bin2hex(random_bytes(32));

        }
    }
}