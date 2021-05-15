<?php


class Db
{

    private static $params = [
        'host' => 'localhost',
        'dbname' => 'awesomeshop',
        'user' => 'admin',
        'password' => '123456',
    ];

    public static function getConnection()
    {
        $params = self::$params;
        $dsn = "mysql:host={$params['host']};dbname={$params['dbname']}";
        $db = new PDO($dsn, $params['user'], $params['password'], [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
        $db->exec("set names utf8");

        return $db;
    }

}
