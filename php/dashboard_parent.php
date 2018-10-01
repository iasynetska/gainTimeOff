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
   
    
    echo "<br /><br /><br />";
    echo $lang['hello'].$parent->name."<br /><a href='./services/do_logout_parent.php'>".$lang['logout']."</a><br >";
    echo "<a href='./add_kid.php'>".$lang['add_kid']."</a><br />";
    echo "<a href='./create_kid_profile.php'>".$lang['create_kid_profile']."</a><br />";
    echo "<hr />";
    echo "DZIECI"."<br />";

    
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
            echo $lang['time_to_play'].": ".$kids[$i]->mins_to_play."<br /><br />";
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
            echo "<button onclick=\"areYouSure('".$kids[$i]->name."')\">".$lang['delete']."</button>";
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
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>Dashboard</title>
        
        <!--Bootstrap Grid CSS & CSS-->
        <link rel="stylesheet" type="text/css" href="../bootstrap/bootstrap-grid.min.css"/>
        
        <!--Fonts Google Almendra-->
        <link href="https://fonts.googleapis.com/css?family=Almendra:400,700&amp;subset=latin-ext" rel="stylesheet">
        
        <!--Custom styles for this template-->
        <link rel="stylesheet" href="../css/main.css"/>
    </head>
    <body id="dashboard_parent">
        <header class="header">
            <nav class="top-nav">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col top-nav_logo">
                            <a href="welcome.php">gainTimeOff</a>
                        </div>
                        <div class="col">
                            <ul class="top-nav_lang justify-content-end">
                                <li>
                                    <a class="nav-link english" href="dashboard_parent.php?lang=en"><?php echo $lang['en']?></a>
                                </li>
                                <li>
                                    <div class="nav-slash">|</div>
                                </li>
                                <li>
                                    <a class="nav-link polish" href="dashboard_parent.php?lang=pl"><?php echo $lang['pl']?></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </nav>
        </header>
        

        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
<!--        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>-->
        
        <!-- Main JavaScript-->
        <script src="../js/common.js"></script>
    </body>
</html>