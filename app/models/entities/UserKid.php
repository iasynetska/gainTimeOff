<?php
namespace models\entities;

use models\KidModel;
use models\SubjectModel;
use models\MarkModel;
use models\TaskModel;

use core\DBDriver;
use core\DbConnection;

class UserKid extends User
{
    public $gender;
    public $date_of_birth;
    public $photo;
    public $parent_id;
    public $time_to_play;
    private $subjects;
    private $marks;
    private $schoolMarks;
    private $tasks;

    public function __construct(
        string $name, 
        string $gender, 
        string $login, 
        string $password, 
        $date_of_birth, 
        $photo, 
        int $parent_id, 
        $time_to_play=0, 
        int $id=NULL
    ){
        parent::__construct($name, $login, $password, $id);

        $this->gender = $gender;
        $this->date_of_birth = $date_of_birth;
        $this->photo = $photo;
        $this->parent_id = $parent_id;
        $this->time_to_play = $time_to_play;
    }
    
    public function getKidSubjects(): ?array
    {
        if(!isset($this->subjects))
        {
            $subjectModel = new SubjectModel(new DBDriver(DbConnection::getPDO()));
            $arr_subjects = $subjectModel->getSubjectsByKid($this);
            
            if(empty($arr_subjects))
            {
                $this->subjects = $arr_subjects;
            }
            else
            {
                foreach($arr_subjects as $subject)
                {
                    $this->subjects[$subject->name] = $subject;
                }
            }
        }
        return $this->subjects;
    }
    
    public function getKidMarks(): ?array
    {
        if(!isset($this->marks))
        {
            $markModel = new MarkModel(new DBDriver(DbConnection::getPDO()));
            $arr_marks = $markModel->getMarksByKid($this);
            
            if(empty($arr_marks))
            {
                $this->marks = $arr_marks;
            }
            else
            {
                foreach($arr_marks as $mark)
                {
                    $this->marks[$mark->name] = $mark;
                }
            }
        }
        return $this->marks;
    }
    
    public function getKidTasks(): ?array
    {
        if(!isset($this->tasks))
        {
            $taskModel = new TaskModel(new DBDriver(DbConnection::getPDO()));
            $arr_tasks = $taskModel->getTasksByKid($this);
            
            if(empty($arr_tasks))
            {
                $this->tasks = $arr_tasks;
            }
            else
            {
                foreach($arr_tasks as $task)
                {
                    $this->tasks[$task->name] = $task;
                }
            }
        }
        return $this->tasks;
    }
    
    public function resetSubjects()
    {
        unset($this->subjects);
    }
    
    public function resetMarks()
    {
        unset($this->marks);
    }
    
    public function resetTasks()
    {
        unset($this->tasks);
    }
}