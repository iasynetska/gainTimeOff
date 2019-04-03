<?php

namespace core;
use \PDO;

class DbConnection
{
    private static $dbType = 'mysql';

    private static $host = 'localhost';

    private static $encoding = 'utf8';

    private static $user = 'root';

    private static $password = '';

    private static $dbName = 'gainTimeOff';

    private static $pdo;


    public static function getPDO(): PDO
    {
        if(!isset(self::$pdo))
        {
            $connectionParams = sprintf(
                    '%s:host=%s;dbname=%s;charset=%s', 
                    self::$dbType, 
                    self::$host, 
                    self::$dbName, 
                    self::$encoding);

            self::$pdo = new \PDO(
                    $connectionParams, 
                    self::$user, 
                    self::$password,
                    [PDO::ATTR_EMULATE_PREPARES=>false, 
                        PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION]);
        }
        return self::$pdo;
    }
}