<?php

namespace core;

use \PDO;

class DbConnection
{
    private static $pdo;


    public static function getPDO(): PDO
    {
        if (!isset(self::$pdo)) {
            $appConfig = new AppConfig();

            $connectionParams = sprintf(
                '%s:host=%s;dbname=%s;user=%s;password=%s',
                $appConfig->getDbType(),
                $appConfig->getDbHost(),
                $appConfig->getDbName(),
                $appConfig->getDbUser(),
                $appConfig->getDbPassword()
            );

            self::$pdo = new \PDO($connectionParams);
        }
        return self::$pdo;
    }
}