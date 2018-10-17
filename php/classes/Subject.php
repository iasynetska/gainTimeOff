<?php
    class Subject 
    {
        public $id;

        public $subject;

        public $kid_id;
        
        public function __construct($subject, $kid_id, $id=NULL) 
        {
            if(isset($id))
            {
                $this->id = $id;
            }
            $this->subject = $subject;
            $this->kid_id = $kid_id;
        }
        
    }
?>