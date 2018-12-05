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


        public function createUserParent(UserParent $parent)
        {

            $sql_statement = $this->pdo->prepare("INSERT INTO user_parents(name, login, email, password)
            VALUES (:name, :login, :email, :password)");
            
            $name = $parent->name;
            $login = $parent->login;
            $email = $parent->email;
            $password = $parent->password;

            $sql_statement->bindParam(':name', $name);
            $sql_statement->bindParam(':login', $login);
            $sql_statement->bindParam(':email', $email);
            $sql_statement->bindParam(':password', $password);

            $sql_statement->execute();
        }
        
        
        public function getParentByLogin(String $login): ?UserParent
        {
            
            $sql_statement = $this->pdo->prepare("SELECT * FROM user_parents WHERE login = :login");
            $sql_statement->bindParam(':login', $login);
            $sql_statement->execute();
            
            $parent = $sql_statement->fetch();
            
            if($parent)
            {
                return new UserParent($parent['name'], $parent['login'], $parent['email'], $parent['password'], $parent['id']);
            }
            return NULL;
        }
        
        
        public function isLoginExisting(String $login): bool
        {
            $sql_statement = $this->pdo->prepare("SELECT * FROM user_parents WHERE login = :login");
            $sql_statement->bindParam(':login', $login);
            $sql_statement->execute();
            
            $rowCount = $sql_statement->rowCount();
            
            return $rowCount > 0;
        }
        
        
        public function isEmailExisting(String $email): bool
        {
            $sql_statement = $this->pdo->prepare("SELECT * FROM user_parents WHERE email = :email");
            $sql_statement->bindParam(':email', $email);
            $sql_statement->execute();
            
            $rowCount = $sql_statement->rowCount();
            
            return $rowCount > 0;
        }
        
        
        public function getNumberOfParents(): int
        {
            $query = "SELECT COUNT(*) FROM user_parents";
            
            $result = $this->pdo->query($query)->fetch();
            
            return $result[0];
        }
    }