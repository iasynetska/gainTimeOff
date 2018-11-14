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
    
    $parent = $_SESSION['parent'];
    
    $kids = $parent->getKids();
    
    if(count($kids) === 0) 
    {
        echo '<a href="./add_kid.php">'.$lang['messenger'].'</a>';
    }
    else
    {
        for($i=0; $i<count($kids); $i++)
        {
            echo "<div id=\"kid-".$kids[$i]->name."\">";
            echo $lang['name'].": ".$kids[$i]->name."<br />";
            if ($kids[$i]->photo === NULL)
            {
                if ($kids[$i]->gender == "girl")
                {
                    echo '<img src="../img/girl.png" alt="girl">';
                }
                else
                {
                    echo '<img src="../img/boy.png" alt="boy">';
                }
            }
            else
            {
                echo '<img src="data:image/jpeg;base64,'.$kids[$i]->photo.'"width="128" height="128"/>';
            }
            echo "<input class='kid' type='checkbox' name='kid-".$i."' value=".$kids[$i]->name.">";
            echo "<br /><br />";
            echo "<hr />";
            echo "</div>";
        }
    }
    
?>

<!DOCTYPE HTML>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Add new kid</title>
        <style>
            .error
            {
                color:red;
                margin-top: 10px;
                margin-bottom: 10px;
            }
	</style>
    </head>
    <body>
        <a href="dashboard_parent_kids.php"><?php echo $lang['back_dashboard']?></a>
        
        <br /><br /><a href="create_kid_profile.php?lang=en"><?php echo $lang['en']?></a>
        <a href="create_kid_profile.php?lang=pl"><?php echo $lang['pl']?></a>
        
        <br /><br /><a href="./services/do_logout.php"><?php echo $lang['logout']?></a>
        
        <h1><?php echo $lang['add_subjects_title']?></h1>
        
        <section id="section_subjects">
            <?php echo $lang['subject']?>: <input id="subject" type="text" name="subject"><br>
            <button onclick="addSubject()"><?php echo $lang['add']?></button><br /><br />
            <div id="subjects"></div>
            <button onclick="collectData()"><?php echo $lang['save']?></button>
        </section>
        
        <!-- jQuery-->
        <script src="../js/jquery-3.3.1.min.js"></script>
        
        <!-- Main JavaScript-->
        <script src="../js/common.js"></script>
    </body>
</html>