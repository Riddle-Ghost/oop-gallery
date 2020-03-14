<?php
namespace App\lib;

Use PDO;

class Db {

    private static $_db = null;

    public static function getInstance() {

        if ( self::$_db === null ) {

            $config = require '../app/config.php';
            $config = $config['db'];

            // Создаём объект PDO, передавая ему следующие переменные:
            self::$_db = new PDO('mysql:host=' . $config['host'] . ';dbname=' . $config['dbname'] . ';charset=' . $config['charset'], $config['user'], $config['password'], $config['opt']);
        }

        return self::$_db;
    }
    
    private function __construct() {
    }
    private function __clone() {
    }
    private function __wakeup() {
    }
}