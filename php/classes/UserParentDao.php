<?php

    /*auto-load Classes*/
    spl_autoload_register(function ($class) 
    {
        require_once $class . '.php';
    });


    class UserParentDao 
    {
        private $pdo;


        public function __construct(PDO $pdo) 
        {
            $this->pdo = $pdo;
        }


        public function createUserParent(UserParent $parent) {

            $stmt = $this->pdo->prepare("INSERT INTO user_parents(name, login, email, password)
            VALUES (:name, :login, :email, :password)");
            
            $name = $parent->name;
            $login = $parent->login;
            $email = $parent->email;
            $password = $parent->password;

            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':login', $login);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $password);

            $stmt->execute();
        }

    }
?>