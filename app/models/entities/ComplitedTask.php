<?php
namespace models\entities;

class ComplitedTask
{
    public $task_id;
    public $date;
    private $id;
    
    public function __construct(
        int $task_id,
        $date,
        int $id=NULL
        ){
            if(isset($id))
            {
                $this->id = $id;
            }
            $this->task_id = $task_id;
            $this->date = $date;
    }
    
    public function getId(): int
    {
        return $this->id;
    }
}