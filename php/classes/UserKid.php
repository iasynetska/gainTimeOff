<?php
    /*auto-load Classes*/
    spl_autoload_register(function ($class) 
    {
        require_once $class . '.php';
    });
    
    
    
    class UserKid extends User
    {
        public $gender;
        
        public $date_of_birth;

        public $photo;

        public $parent_id;

        public $mins_to_play;
        
        private $subjects;
        
        private $marks;
        
        private $school_marks;
        
        public function __construct(
            string $name, 
            string $gender, 
            string $login, 
            string $password, 
            $date_of_birth, 
            $photo, 
            int $parent_id, 
            $mins_to_play=0, 
            int $id=NULL
        ){
            parent::__construct($name, $login, $password, $id);
            
            $this->gender = $gender;
            $this->date_of_birth = $date_of_birth;
            $this->photo = $photo;
            $this->parent_id = $parent_id;
            $this->mins_to_play = $mins_to_play;
        }
        
        public function getSubjects(): array
        {
            if(!isset($this->subjects))
            {
                $subjectDao = new SubjectDao(DbConnection::getPDO());
                $arr_subjects = $SubjectDao->getSubjectsByKid($this);
                
                foreach($arr_subjects as $subject)
                {
                    $this->subjects[$subject->name] = $subject;
                }
            }
            
            return $this->subjects;
        }
    }