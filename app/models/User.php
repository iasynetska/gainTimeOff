<?php

namespace models;

class User
{
    private $id;

    public $name;

    public $login;

    public $password;


    public function __construct(
        string $name, 
        string $login, 
        string $password, 
        int $id=NULL
    ){
        if(isset($id))
        {
            $this->id = $id;
        }
        $this->name = $name;
        $this->login = $login;
        $this->password = $password;
    }


    public function getId(): int
    {
        return $this->id;	
    }

}