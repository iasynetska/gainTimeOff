<?php

namespace core;
use \PDO;

class DbConnection
{
    private static $pdo;

    public static function getPDO(): PDO
    {
        if(!isset(self::$pdo))
        {
            $connectionParams = sprintf(
                    '%s:host=%s;dbname=%s;charset=%s', 
                    AppConfig::DB_TYPE, 
                    AppConfig::DB_HOST, 
                    AppConfig::DB_NAME, 
                    AppConfig::DB_ENCODING);

            self::$pdo = new \PDO(
                    $connectionParams, 
                    AppConfig::DB_USER, 
                    AppConfig::DB_PASSWORD,
                    [PDO::ATTR_EMULATE_PREPARES=>false, 
                        PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION]);
        }
        return self::$pdo;
    }
}