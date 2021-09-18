<?php

namespace App;

class Session
{
    protected const FLASH_KEY = 'flash_messages';

    public function __construct()
    {
        session_start();
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

    public function setFlash($key, $message)
    {
        $_SESSION[self::FLASH_KEY][$key] = $message;
    }

    public function getFlash($key)
    {

    }
}