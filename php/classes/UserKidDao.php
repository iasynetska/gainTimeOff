<?php

    /*auto-load Classes*/
    spl_autoload_register(function ($class) 
    {
        require_once $class . '.php';
    });


    class UserKidDao 
    {
        private $pdo;


        public function __construct(PDO $pdo) 
        {
            $this->pdo = $pdo;
        }
        
        
        public function createUserKid(UserKid $kid)
        {

            $sql_statement = $this->pdo->prepare("INSERT INTO user_kids(name, login, password, date_of_birth, photo, parent_id)
            VALUES (:name, :login, :password, :date_of_birth, :photo, :parent_id)");
            
            $name = $kid->name;
            $login = $kid->login;
            $password = $kid->password;
            $date_of_birth = $kid->date_of_birth;
            $photo = $kid->photo;
            $parent_id = $kid->parent_id;

            $sql_statement->bindParam(':name', $name);
            $sql_statement->bindParam(':login', $login);
            $sql_statement->bindParam(':password', $password);
            $sql_statement->bindParam(':date_of_birth', $date_of_birth);
            $sql_statement->bindParam(':photo', $photo);
            $sql_statement->bindParam(':parent_id', $parent_id);

            $sql_statement->execute();
        }
        
        
        public function getKidsByParentId($parentId)
        {
            $sql_statement = $this->pdo->prepare("SELECT * FROM user_kids WHERE parent_id = :parent_id");
            
            $sql_statement->bindParam(':parent_id', $parentId);
            
            $sql_statement->execute();
            
            $kids_result = $sql_statement->fetchAll();
            
            $arr_kids = [];            
            foreach ($kids_result as $result)
            {
                $kid = new UserKid($result['name'], $result['login'], $result['password'], $result['date_of_birth'], $result['photo'], 
                        $result['parent_id'], $result['mins_to_play'], $result['id']);
                array_push($arr_kids, $kid);
            }
            
            return $arr_kids;
        }
        
        
        public function isLoginExisting(String $login, $parentId)
        {
            $sql_statement = $this->pdo->prepare("SELECT * FROM user_kids WHERE login = :login && parent_id = :parent_id");
            
            $sql_statement->bindParam(':login', $login);
            
            $sql_statement->bindParam(':parent_id', $parentId);
            
            $sql_statement->execute();
            
            $rowCount = $sql_statement->rowCount();
            
            return $rowCount > 0;
        }
    }
