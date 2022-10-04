<?php

namespace App\Models;
class DB
{
    private static $db = null;

    public static function getInstance()
    {
        if (self::$db == null) {
            self::$db = new \PDO('mysql:host=' . $_ENV['DB_HOST'] . ';dbname=' . $_ENV['DB_NAME'], $_ENV['DB_USER'], $_ENV['DB_PASSWORD']);
        }
        return self::$db;
    }

    public function __construct() {}
    public function __clone() {}
    public function __wakeup() {}
}