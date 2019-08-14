<?php
namespace models\entities;

class TimeToPlay
{
    public $time;
    public $date;
    public $kid_id;
    private $id;
    
    public function __construct(
        int $time,
        $date,
        int $kid_id,
        int $id=NULL
        ){
            if(isset($id))
            {
                $this->id = $id;
            }
            $this->time = $time;
            $this->date = $date;
            $this->kid_id = $kid_id;
    }
    
    public function getId():int
    {
        return $this->id;
    }
}