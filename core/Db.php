<?php


class Db
{

    private static $params = [
        'host' => 'localhost',
        'dbname' => 'awesome_shop',
        'user' => 'root',
        'password' => '',
    ];

    public static function getConnection()
    {
        $params = self::$params;
        $dsn = "mysql:host={$params['host']};dbname={$params['dbname']}";
        $db = new PDO($dsn, $params['user'], $params['password']);
        $db->exec("set names utf8");

        return $db;
    }

}
