<?php
namespace models\entities;

class Task 
{        
    public $name;
    public $gameTime;
    public $kid_id;
    private $id;
    
    public function __construct(
        string $name,
        $gameTime,
        int $kid_id,
        int $id=NULL
        ){
            if(isset($id))
            {
                $this->id = $id;
            }
            $this->name = $name;
            $this->gameTime = $gameTime;
            $this->kid_id = $kid_id;
    }
    
    public function getId(): int
    {
        return $this->id;
    }
}