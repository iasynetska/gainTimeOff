<?php 
namespace models\entities;

class Subject 
{
    public $subject;
    public $kid_id;
    public $active;
    private $id;
    
    public function __construct(
        string $subject,
        int $active,
        int $kid_id,
        int $id=NULL
        ){
            if(isset($id))
            {
                $this->id = $id;
            }
            $this->subject = $subject;
            $this->kid_id = $kid_id;
            $this->active = $active;
    }
    
    public function getId(): int
    {
        return $this->id;
    }
}