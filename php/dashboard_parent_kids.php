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
   
    
//    echo "<div>***MENU***</div><br >";
//    echo "<a href='dashboard_parent_kids.php'>".$lang['kids']."</a><br ><br >";
//    echo "<hr />";
//    
//    $arr_kids = $parent->getKids();
//    
//    if(!isset($arr_kids)) 
//    {
//        echo "<div>**************</div>";
//        echo "<a href='add_kid.php'>".$lang['add_kid']."</a>";
//        echo "<div>**************</div>";
//    }
//    else
//    {
//        foreach($arr_kids as $kid)
//        {
//            if ($kid->photo === NULL)
//            {
//                if ($kid->gender == "girl")
//                {
//                    echo '<img src="../img/girl.png" alt="girl">';
//                }
//                else
//                {
//                    echo '<img src="../img/boy.png" alt="boy">';
//                }
//            }
//            else
//            {
//                echo '<img src="data:image/jpeg;base64,'.$kid->photo.'"width="128" height="128"/>';
//            }
//            echo "<button onclick=\"areYouSure('".$kid->name."')\">".$lang['delete']."</button>";
//            echo "<br /><br />";
//            echo "<div id=\"kid-".$kid->name."\">";
//            echo $lang['name'].": ".$kid->name."---<a href='edit_kid.php'>".$lang['edit']."</a><br />";
//            echo "Login: ".$kid->login;
//            echo "<br /><br />";
//            echo $lang['time_to_play'].": ".$kid->mins_to_play."<br /><br />";
//            echo "<hr />";
//            echo "</div>";
//        }
//        echo "<div>**************</div>";
//        echo "<a href='add_kid.php'>".$lang['add_kid']."</a>";
//        echo "<div>**************</div>";
//    }
//?>

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
        
        <!--Adding Fonts-->
        <link rel="stylesheet" type="text/css" href="../css/fonts.css"/>
        
        <!--Custom styles for this template-->
        <link rel="stylesheet" href="../css/style.css"/>
    </head>
    <body id="dashboard_parent_kids">
        <?php 
            include_once 'header.php';
        ?>
        
        <div class="wrapper d-flex flex-column" style="min-height: 100vh;">
            <main class="dashboard d-flex flex-wrap flex-row flex-grow-1">
                <div class="dashboard-aside d-flex">
                    <div class="aside-menu d-flex flex-column justify-content-center">
                        <div class="aside-menu__item">
                            <?php echo "<a href='dashboard_parent_kids.php'>".$lang['kids']."</a>";?>
                        </div>
                        <div class="aside-menu__item">
                            <?php echo "<a href='dashboard_parent_kids.php'>".$lang['kids']."</a>";?>
                        </div>
                    </div>
                </div>
                <div class="dashboard-content d-flex flex-column">
                    <div class="content-header d-flex justify-content-end">
                        <div class="content-header__logout">
                            <?php
                                echo $lang['hello'].$parent->name;
                                echo"<div class='form__link'><a href='./services/do_logout_parent.php'>".$lang['logout']."</a></div>";
                            ?>
                        </div>
                    </div>
                    <div class="content-main d-flex justify-content-center">
                        <div class="content-main__block">
                            <a href='add_kid.php'><img src="../img/plus-128.png" alt="Add kid"></a>
                            <div class="content-main__text">
                                <?php echo "<a href='add_kid.php'>".$lang['add_kid']."</a>"?>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
            
            <?php 
                include_once 'footer.php';
            ?> 
        </div>
                

        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
<!--        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>-->
        
        <!-- Main JavaScript-->
        <script src="../js/common.js"></script>
    </body>
</html>