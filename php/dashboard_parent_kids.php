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
    
    $arr_kids_names = array_keys($arr_kids);
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
                                echo"<div class='logout-link'><a href='./services/do_logout.php'>".$lang['logout']."</a></div>";
                            ?>
                        </div>
                    </div>
                    <?php 
                        if(!isset($arr_kids)) 
                        {
                            echo
                            '<div class="content-main flex-grow-1 d-flex flex-column justify-content-center align-items-center">
                                <div class="content-main__block"  onclick="location.href=\'add_kid.php\';">
                                    <img src="../img/plus-128.png" alt="Add kid">
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
                                        <div class="kids-new"><img class="kids-new__img" onclick="location.href=\'add_kid.php\';" src="../img/plus-32.png" alt="Add kid"></div>
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
                                                    <i class="far fa-trash-alt icon" onclick="areYouSure(\''.$kid->name.'\')"></i>
                                                </div>';
                                if ($kid->photo === NULL)
                                {
                                    if ($kid->gender == "girl")
                                    {
                                        echo 
                                                '<img src="../img/girl_small.png" alt="girl">';
                                    }
                                    else
                                    {
                                        echo 
                                                '<img src="../img/boy_small.png" alt="boy">';
                                    }
                                }
                                else
                                {
                                    echo 
                                                '<img src="data:image/jpeg;base64,'.$kid->photo.'"width="64" height="64"/>';
                                }
                                echo
                                                '<div class="kid-name">'.$kid->name.'<i class="far fa-edit icon"></i></div>
                                            </div><!-- /.kid -->';
                            }
                            echo
                                        '</div><!-- /.kids-blocks -->
                                    </div><!-- /.container -->    
                                </div><!-- /.kids -->
                            
                                <table class="kids-table">
                                    <tr>
                                        <th colspan="3">XXX</th>
                                    </tr>
                                    <tr>
                                        <td colspan="3">'.$lang['time_to_play'].':XXX</td>
                                    </tr>
                                    <tr>
                                        <td width="33%">'.$lang['school_subjects'].'</td>
                                        <td width="33%">'.$lang['tasks'].'</td>
                                        <td width="33%">'.$lang['played_time'].'</td>
                                    </tr>
                                    <tr>
                                        <td>'
                                            .$lang['create_sub_and_marks'].'<br />
                                            <img src="../img/plus-32.png" onclick="location.href=\'create_subjects_and_marks.php\';">
                                        </td>
                                        <td>
                                            '.$lang['create_tasks'].'<br />
                                            <img src="../img/plus-32.png" onclick="location.href=\'create_kid_profile.php\';">
                                        </td>
                                        <td>
                                            '.$lang['played_time'].'
                                        </td>
                                    </tr>
                                </table>';
                        }
                    ?>
                </div>
            </main>
            
            <?php 
                include_once 'footer.php';
            ?> 
        </div>
                     
        <!-- Main JavaScript-->
        <script src="../js/common.js"></script>
    </body>
</html>