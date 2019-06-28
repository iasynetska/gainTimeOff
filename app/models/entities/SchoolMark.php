<?php
namespace models\entities;

class SchoolMark
{
    public $subject_id;
    public $mark_id;
    public $date;
    public $note;
    private $id;
    
    public function __construct(
        int $subject_id,
        int $mark_id,
        $date,
        string $note,
        int $id=NULL
        ){
            if(isset($id))
            {
                $this->id = $id;
            }
            $this->subject_id = $subject_id;
            $this->mark_id = $mark_id;
            $this->date = $date;
            $this->note = $note;
    }
    
    public function getId():int
    {
        return $this->id;
    }
}