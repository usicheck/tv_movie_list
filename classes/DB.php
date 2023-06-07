<?php

class DB {

    public static function getConnection() {
        static $connection = null;

        if (null === $connection) {
            $dns = 'mysql:host=mysql;port=3306;dbname=test_yaroslava_kurbatova;charset=utf8mb4';

            $connection = new PDO($dns, 'root', 'root', [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ]);
        }

        return $connection;
    }
}