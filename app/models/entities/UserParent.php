<?php
namespace models\entities;

class UserParent extends User
{
    public $email;
    
    public function __construct
    (
        string $name,
        string $login,
        string $email,
        string $password,
        int $id=NULL
    ){
        parent::__construct($name, $login, $password, $id);
        
        $this->email = $email;
    }
}