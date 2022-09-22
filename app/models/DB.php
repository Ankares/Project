<?php
    class DB {

        private static $db = null;
  
        public static function getInstence() {
          if(self::$db == null) {
              self::$db = new PDO('mysql:host=mysql;dbname=project', 'artem', 'password');
          }
          return self::$db;
        }
  
        public function __construct() {}
        public function __clone() {}
        public function __wakeup() {}
      }