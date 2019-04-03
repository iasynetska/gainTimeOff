<?php

    /*auto-load Classes*/
    spl_autoload_register(function ($class) 
    {
        require_once $class . '.php';
    });


    class MarkDao 
    {
        private $pdo;


        public function __construct(PDO $pdo) 
        {
            $this->pdo = $pdo;
        }
        
        
        public function createMark(Marks $marks)
        {

            $sql_statement = $this->pdo->prepare("INSERT INTO marks(mark, minutes, kid_id)
            VALUES (:mark, :minutes, :kid_id)");
            
            $mark = $marks->mark;
            $minutes = $marks->minutes;
            $kid_id = $marks->kid_id;

            $sql_statement->bindParam(':mark', $mark);
            $sql_statement->bindParam(':minutes', $minutes);
            $sql_statement->bindParam(':kid_id', $kid_id);

            $sql_statement->execute();
        }
    }
