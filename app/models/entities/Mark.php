<?php
namespace models\entities;

class Mark 
{
    public $name;
    public $minutes;
    public $kid_id;
    public $active;
    private $id;
    
    public function __construct(
        string $name, 
        $minutes, 
        int $kid_id,
        int $active,
        int $id=NULL
    ){
        if(isset($id))
        {
            $this->id = $id;
        }
        $this->name = $name;
        $this->minutes = $minutes;
        $this->kid_id = $kid_id;
        $this->active = $active;
    }
    
    public function getId():int 
    {
        return $this->id;	
    }
}