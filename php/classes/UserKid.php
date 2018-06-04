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
        
        public function __construct($name, $gender, $login, $password, $date_of_birth, $photo, $parent_id, $mins_to_play=0, $id=NULL)
        {
            parent::__construct($name, $login, $password, $id);
            
            $this->gender = $gender;
            $this->date_of_birth = $date_of_birth;
            $this->photo = $photo;
            $this->parent_id = $parent_id;
            $this->mins_to_play = $mins_to_play;
        }
    }