<?php

namespace App;

use PDO;

class Database
{
    private static ?PDO $db = null;

    public static function getPDO(): PDO
    {
        if (self::$db === null) {
            self::$db = new PDO(
                $_ENV['DSN'],
                $_ENV['DB_USER'],
                $_ENV['DB_PASSWORD'],
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
                ]);
        }

        return self::$db;
    }
}