<?php

namespace models;
use models\User;

/*auto-load Classes*/
spl_autoload_register(function ($class) 
{
    require_once $GLOBALS['_BASE_PATH_'] . str_replace('\\', '/', $classname) . '.php';
});



class UserKid extends User
{
    public $gender;

    public $date_of_birth;

    public $photo;

    public $parent_id;

    public $mins_to_play;

    private $subjects;

    private $marks;

    private $school_marks;

    public function __construct(
        string $name, 
        string $gender, 
        string $login, 
        string $password, 
        $date_of_birth, 
        $photo, 
        int $parent_id, 
        $mins_to_play=0, 
        int $id=NULL
    ){
        parent::__construct($name, $login, $password, $id);

        $this->gender = $gender;
        $this->date_of_birth = $date_of_birth;
        $this->photo = $photo;
        $this->parent_id = $parent_id;
        $this->mins_to_play = $mins_to_play;
    }
}