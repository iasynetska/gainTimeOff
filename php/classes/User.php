<?php
    class User
    {
        private $id;

        public $name;

        public $login;

        public $password;
        
        
        public function __construct($name, $login, $password, $id=NULL) 
        {
            if(isset($id))
            {
                $this->id = $id;
            }
            $this->name = $name;
            $this->login = $login;
            $this->password = $password;
        }
        

        public function getId() 
        {
            return $this->id;	
        }

    }
?>