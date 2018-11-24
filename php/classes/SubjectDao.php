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
        
        
        public function getSubjectsByKid(UserKid $kid): array
        {
            $sql_statement = $this->pdo->prepare("SELECT * FROM subjects WHERE kid_id = :kid_id");
            
            $sql_statement->bindParam(':kid_id', $kid->getId());
            
            $sql_statement->execute();
            
            $subjects_result = $sql_statement->fetchAll();
            
            $arr_subjects = [];
            foreach ($subjects_result as $result)
            {
                $subject = new Subject($result['subject'], $result['id']);
                array_push($arr_subjects, $subject);
            }
            
            return $arr_subjects;
        }
    }

?>