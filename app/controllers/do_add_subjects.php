<?php

    //auto-load Classes
    spl_autoload_register(function ($class) 
    {
        require_once '../classes/' . $class . '.php';
    });
    
    session_start();
    
    include_once "../lang_config.php";
    
    
    
    //check if authorised
    if (!isset($_SESSION['parent']))
    {
        header('Location: ../welcome.php');
        exit();
    }         
    
    $parent = $_SESSION['parent'];
    $kidsName = $_POST['kidsName'];
    $subjects = $_POST['subjects'];
    
    $name = json_decode($kidsName);
    $sub = json_decode($subjects);

    $kids = $parent->getKids();
    
    for($i=0; $i<count($name); $i++)
    {
        $kidName = $name[$i];
        for($j=0; $j<count($kids); $j++)
        {
            if($kidName == $kids[$j]->name)   
            {
                $kidId = $kids[$j]->getId();
                for($k=0; $k<count($sub); $k++)
                {
                    $subject = new Subject($sub[$k], $kidId);
                
                    $subjectDao = new SubjectDao(DbConnection::getPDO());
                    $subjectDao->addSubject($subject);
                }
            }
        }
    }
    
    echo "It works";