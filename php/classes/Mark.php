<?php
    class Mark 
    {
        private $id;

        public $mark;

        public $minutes;

        public $kid_id;
        
        public function __construct($mark, $minutes, $kid_id, $id=NULL)
        {
            if(isset($id))
            {
                $this->id = $id;
            }
            $this->mark = $mark;
            $this->minutes = $minutes;
            $this->kid_id = $kid_id;
        }
        
        public function getId() 
        {
            return $this->id;	
        }
    }
?>
