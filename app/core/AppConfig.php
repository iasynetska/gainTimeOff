<?php
namespace core;

final class AppConfig
{
    private $dbType;
    private $dbHost;
    private $dbUser;
    private $dbPassword;
    private $dbName;


    public function __construct()
    {
        $this->dbType = 'pgsql';
        $this->dbHost = getenv('DB_HOST');
        $this->dbUser = getenv('DB_USER');
        $this->dbPassword = getenv('DB_PASSWORD');
        $this->dbName = getenv('DB_NAME');
    }

    public function getDbType(): string
    {
        return $this->dbType;
    }

    public function getDbHost()
    {
        return $this->dbHost;
    }

    public function getDbUser()
    {
        return $this->dbUser;
    }

    public function getDbPassword()
    {
        return $this->dbPassword;
    }

    public function getDbName()
    {
        return $this->dbName;
    }


}