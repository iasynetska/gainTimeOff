<?php
    class Subject 
    {
        public $id;

        public $name;

        public $kid_id;
        
        public function __construct(
            string $name, 
            int $kid_id, 
            int $id=NULL
        ){
            if(isset($id))
            {
                $this->id = $id;
            }
            $this->name = $name;
            $this->kid_id = $kid_id;
        }
        
        public function getId():int 
        {
            return $this->id;	
        }
    }
?>