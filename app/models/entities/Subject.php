<?php 
namespace models\entities;

class Subject 
{
    public $name;
    public $kid_id;
    public $active;
    private $id;
    
    public function __construct(
        string $name,
        int $active,
        int $kid_id,
        int $id=NULL
        ){
            if(isset($id))
            {
                $this->id = $id;
            }
            $this->name = $name;
            $this->kid_id = $kid_id;
            $this->active = $active;
    }
    
    public function getId(): int
    {
        return $this->id;
    }
}