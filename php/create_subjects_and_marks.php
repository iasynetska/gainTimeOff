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
    
    <body id="create_subjects">
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
                    <div class="content-main flex-grow-1 d-flex flex-wrap justify-content-around align-items-center">
                        <form class="subject-add form" action=".services/do_add_subjects.php" method="post">
                            <div class="form__title"><?php echo $lang['add_subjects_title']?></div>
                            <input id="subject-new" class="form__field field-80" type="text" name="subject" />
                            <img class="form__plus" src="../img/plus-32.png" alt="add" onclick="addSubject()">
                            <div id="form__list"></div>
                            <input class="form__btn" type="submit" value="<?php echo $lang['save']?>" />
                        </form>

                        <div class="content-main__form tasks">
                            <div class="form__title"><?php echo $lang['add_marks_title']?></div>
                        </div>
                    </div>
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

