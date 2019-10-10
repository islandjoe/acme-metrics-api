<?php namespace Dopmn\Core;

use PDO;

class Db
{
    private static $instance;

    public static function getInstance()
    {
        if (self::$instance == null)
        {
            self::$instance = self::connect();
        }

        return self::$instance;
    }

    private static function connect(): PDO
    {
        $dsn = 'mysql:host=mysql;dbname=dopmn;charset=utf8mb4;port=3306';
        try
        {
            return new PDO($dsn, 'dev', 'dev');
        }
        catch (\PDOException $e)
        {
            exit('Database connection could not be established.');
        }
    }


}
