<?php
namespace models;

use core\DBDriver;
use models\entities\User;

abstract class BaseModel
{
    protected $dbDriver;
    protected $nameTable;
    
    public function __construct(DBDriver $dbDriver, $nameTable) 
    {
        $this->dbDriver = $dbDriver;
        $this->nameTable = $nameTable;
    }
    
    public function login($login, $password) 
    {
        $user = $this->getByLogin($login);
        
        if($user && password_verify($password, $user->password))
        {
            return $user;
        }
        else 
        {
            return false;
        }
    }
    
    public function getByLogin($login): ?User
    {
        $sql = sprintf("SELECT * FROM %s WHERE login =:login", $this->nameTable);
        $userData = $this->dbDriver->select($sql, ['login' => $login], DBDriver::FETCH_ONE);
        if($userData)
        {
            return $this->createEntity($userData);
        }
        else 
        {
            return NULL;
        }
        
    }
    
    abstract protected function createEntity(array $fields): User;
}