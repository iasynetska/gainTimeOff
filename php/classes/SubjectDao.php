<?php

    /*auto-load Classes*/
    spl_autoload_register(function ($class) 
    {
        require_once $class . '.php';
    });
    
    
    class SubjectDao 
    {
        private $pdo;


        public function __construct(PDO $pdo) 
        {
            $this->pdo = $pdo;
        }
        
        
        public function addSubject(Subject $subjects)
        {
            
            $sql_statement = $this->pdo->prepare("INSERT INTO subjects (subject, kid_id) "
                    . "VALUES (:subject, :kidId)");
            
            $subject = $subjects->subject;
            $kidId = $subjects->kid_id;
            
            $sql_statement->bindParam(':subject', $subject); 
            $sql_statement->bindParam(':kidId', $kidId);
            
            $sql_statement->execute();
        }
    }

?>