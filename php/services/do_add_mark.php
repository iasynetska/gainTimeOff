<?php
   
    /*auto-load Classes*/
    spl_autoload_register(function ($class) 
    {
        require_once '../classes/' . $class . '.php';
    });
    
    session_start();
    
    include_once "../lang_config.php";
    
 
    
    $mark = filter_input(INPUT_POST, 'mark');
    $minutes = filter_input(INPUT_POST, 'minutes');
    
    $kid = $_SESSION['kid'];
    
    $markDao = new MarkDao(DbConnection::getPDO());
    $kid_id = $kid->getId();
    
    
    $marks = new Mark($mark, $minutes, $kid_id);
    $markDao->createMark($marks);
    
    $_SESSION['marks'] = $marks;

    header('Location: /gaintimeoff/php/add_subjects.php');
