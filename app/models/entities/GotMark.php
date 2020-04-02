<?php
namespace models\entities;

class ReceivedMark
{
    public $subject_id;
    public $mark_id;
    public $date;
    private $id;
    
    public function __construct(
        int $subject_id,
        int $mark_id,
        $date,
        int $id=NULL
        ){
            if(isset($id))
            {
                $this->id = $id;
            }
            $this->subject_id = $subject_id;
            $this->mark_id = $mark_id;
            $this->date = $date;
    }
    
    public function getId():int
    {
        return $this->id;
    }
}