<?php
    /*auto-load Classes*/
    spl_autoload_register(function ($class) 
    {
        require_once $class . '.php';
    });
    
    
    class UserParent extends User
    {
        public $email;
        
        private $kids;

        public function __construct($name, $login, $email, $password, $id=NULL) 
        {
            parent::__construct($name, $login, $password, $id);

            $this->email = $email;
        }

        
        public function getKids()
        {
            if(!isset($this->kids))
            {
                $userKidDao = new UserKidDao(DbConnection::getPDO());
                
                $arr_kids = $userKidDao->getKidsByParentId($this->getId());
                
                foreach($arr_kids as $kid)
                {
                    $this->kids[$kid->name] = $kid;
                }
            }
            
            return $this->kids;
        }
        
        
        public function reloadKids()
        {
            unset($this->kids);
        }
    }
?>