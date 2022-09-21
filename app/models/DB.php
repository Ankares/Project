<?php

$env = $_ENV['DB_USER'];
echo $env;

    class DB {

        private static $_db = null;
  
        public static function getInstence() {
          if(self::$_db == null) {
              self::$_db = new PDO('mysql:host=localhost; dbname=users', 'testUser', 'testPassword');
          }
          return self::$_db;
        }
  
        public function __construct() {}
        public function __clone() {}
        public function __wakeup() {}
      }