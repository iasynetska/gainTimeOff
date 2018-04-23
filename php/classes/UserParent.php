<?php
    class UserParent 
    {
        private $id;

        public $name;

        public $login;

        public $email;

        public $password;


        public function __construct($name, $login, $email, $password, $id=NULL) 
        {
            if(isset($id))
            {
                $this->id = $id;
            }
            $this->name = $name;
            $this->login = $login;
            $this->email = $email;
            $this->password = $password;
        }


        public function getId() 
        {
            return $this->id;	
        }
    }
?>