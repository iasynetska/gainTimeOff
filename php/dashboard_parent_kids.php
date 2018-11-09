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
    
    $arr_kids = $parent->getKids();
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
        
        <!--Fonts Awesome-->
<!--        <link rel="stylesheet" href="../libs/font-awesome/css/fontawesome.min.css"/>-->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
        
        <!--Adding Fonts-->
        <link rel="stylesheet" type="text/css" href="../css/fonts.css"/>
        
        <!--Custom styles for this template-->
        <link rel="stylesheet" href="../css/style.css"/>
    </head>
    
    <body id="dashboard_parent_kids">
        <div class="wrapper d-flex flex-column">
            <?php 
                include_once 'header.php';
            ?>

            <main class="dashboard d-flex flex-grow-1">
                <?php
                    include_once 'sidebar.php';
                ?>
                
                <div class="dashboard-content flex-grow-1 d-flex flex-column">
                    <div class="content-header">
                        <div class="content-header__logout">
                            <?php
                                echo "<div class='logout-text'>".$lang['hello'].$parent->name."</div>";
                                echo"<div class='logout-link'><a href='./services/do_logout_parent.php'>".$lang['logout']."</a></div>";
                            ?>
                        </div>
                    </div>
                    <?php 
                        if(!isset($arr_kids)) 
                        {
                            echo
                            '<div class="content-main flex-grow-1 d-flex flex-column justify-content-center align-items-center">
                                <div class="content-main__block"  onclick="location.href="add_kid.php";">
                                    <a class="content-main__img" href="add_kid.php"><img src="../img/plus-128.png" alt="Add kid"></a>
                                    <div class="content-main__text">
                                        <a href="add_kid.php">'.$lang["add_kid"].'</a>
                                    </div>
                                </div>
                            </div>';
                        }
                        else 
                        {
                            echo    
                                '<div class="kids">
                                    <div class="container">
                                        <h1 class="kids-title">'.$lang["my_kids"].'</h1>
                                        <div class="kids-blocks d-flex flex-wrap justify-content-center">';
                            foreach($arr_kids as $kid)
                            {
                                if($kid === reset($arr_kids))
                                {
                                    echo 
                                            '<div id="'.$kid->name.'" class="kid active-profile d-flex flex-column justify-content-center align-items-center" onclick="changeActiveProfile(this.id)">';
                                }
                                else
                                {
                                    echo 
                                            '<div id="'.$kid->name.'" class="kid d-flex flex-column justify-content-center align-items-center" onclick="changeActiveProfile(this.id)">';
                                }
                                echo 
                                                '<div class="kid-delete">
                                                    <i class="far fa-trash-alt"></i>
                                                </div>';
                                if ($kid->photo === NULL)
                                {
                                    if ($kid->gender == "girl")
                                    {
                                        echo 
                                                '<img src="../img/girl.png" alt="girl">';
                                    }
                                    else
                                    {
                                        echo 
                                                '<img src="../img/boy.png" alt="boy">';
                                    }
                                }
                                else
                                {
                                    echo 
                                                '<img src="data:image/jpeg;base64,'.$kid->photo.'"width="128" height="128"/>';
                                }
                                echo
                                                '<div class="kid-name">'.$kid->name.'</div>
                                            </div><!-- /.kid -->';
//                                echo "<button onclick=\"areYouSure('".$kid->name."')\">".$lang['delete']."</button>";
//                                echo "<br /><br />";
//                                echo "<div id=\"kid-".$kid->name."\">";
//                                echo $lang['name'].": ".$kid->name."---<a href='edit_kid.php'>".$lang['edit']."</a><br />";
//                                echo "Login: ".$kid->login;
//                                echo "<br /><br />";
//                                echo $lang['time_to_play'].": ".$kid->mins_to_play."<br /><br />";
//                                echo "<hr />";
//                                echo "</div>";
                            }
                            echo
                                        '</div><!-- /.kids-blocks -->
                                    </div><!-- /.container -->    
                                </div><!-- /.kids -->';
                        }
                    ?>
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