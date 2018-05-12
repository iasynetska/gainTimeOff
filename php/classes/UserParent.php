<?php
    class UserParent extends User
    {
        public $email;
        

        public function __construct($name, $login, $email, $password, $id=NULL) 
        {
            parent::__construct($name, $login, $password, $id);

            $this->email = $email;
        }
    }
?>