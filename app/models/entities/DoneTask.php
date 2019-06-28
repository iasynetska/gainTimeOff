<?php
namespace models\entities;

class DoneTask
{
    public $task_id;
    public $date;
    public $note;
    private $id;
    
    public function __construct(
        int $task_id,
        $date,
        string $note,
        int $id=NULL
        ){
            if(isset($id))
            {
                $this->id = $id;
            }
            $this->task_id = $task_id;
            $this->date = $date;
            $this->note = $note;
    }
    
    public function getId(): int
    {
        return $this->id;
    }
}