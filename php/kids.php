<?php

    //auto-load Classes
    spl_autoload_register(function ($class) 
    {
        require_once 'classes/' . $class . '.php';
    });
    
    session_start();
    
    include_once "lang_config.php";
    
    
    
    //check if authorised
    if (!isset($_SESSION['parent']))
    {
        header('Location: welcome.php');
        exit();
    }
?>


<!DOCTYPE HTML>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Add new kid</title>
    </head>
    <body>
        <br /><br /><a href="kids.php?lang=en"><?php echo $lang['en']?></a>
        <a href="kids.php?lang=pl"><?php echo $lang['pl']?></a>
        
        <br /><br /><a href="./add_kid.php"><?php echo $lang['add_kid']?></a>
        <br /><br /><a href="./services/do_logout_parent.php"><?php echo $lang['logout']?></a>
    </body>
</html>