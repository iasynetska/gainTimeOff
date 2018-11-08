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
?>


<!DOCTYPE HTML>
<html lang="en">
    <html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>Adding kid</title>
        
        <style>
            .error
            {
                color:red;
                margin-bottom: 10px;
            }
	</style>
        
        <!--Bootstrap Grid CSS & CSS-->
        <link rel="stylesheet" type="text/css" href="../bootstrap/bootstrap-grid.min.css"/>
        
        <!--Adding Fonts-->
        <link rel="stylesheet" type="text/css" href="../css/fonts.css"/>
        
        <!--Custom styles for this template-->
        <link rel="stylesheet" href="../css/style.css"/>
        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    </head>
    
    <body id="add_kid">
        <div class="wrapper d-flex flex-column">
            <?php 
                include_once 'header.php';
            ?>

            <main class="adding d-flex flex-grow-1">
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
                    <div class="content-main flex-grow-1 d-flex flex-column justify-content-center align-items-center">
                        <form class="adding-kid form" action="./services/do_add_kid.php" method="post" enctype = "multipart/form-data">
                            <div class="form__title">
                                <?php echo $lang['add_kid']?>
                            </div>
                            
                            <!--field Name-->
                            <label>
                                <?php echo $lang['name']?>: 
                                <input class="form__field" type="text" value="<?php
                                    if(isset($_SESSION['tmp_name']))
                                    {
                                        echo $_SESSION['tmp_name'];
                                    }
                                ?>" name="name" />
                                <?php 
                                    if(isset($_SESSION['error_name']))
                                    {
                                        echo "<div class='error'>".$_SESSION['error_name']."</div>";
                                        unset($_SESSION['error_name']);
                                    }
                                ?>
                            </label>

                            <!--field Gender-->
                            <input type="radio" name="gender" value="boy"><?php echo $lang['boy']?>
                            <input type="radio" name="gender" value="girl"><?php echo $lang['girl']?><br />
                            <?php
                                if(isset($_SESSION['error_gender']))
                                {
                                    echo "<div class='error'>".$_SESSION['error_gender']."</div>";
                                    unset($_SESSION['error_gender']);
                                }
                            ?>

                            <!--field Login-->
                            <label>
                                Login:
                                <input class="form__field" type="text" value="<?php
                                    if(isset($_SESSION['tmp_login']))
                                    {
                                        echo $_SESSION['tmp_login'];
                                    }
                                    ?>" name="login" /><br />
                                <?php
                                    if(isset($_SESSION['error_login']))
                                    {
                                        echo "<div class='error'>".$_SESSION['error_login']."</div>";
                                        unset($_SESSION['error_login']);
                                    }
                                    if(isset($_SESSION['error_alnum_login']))
                                    {
                                        echo "<div class='error'>".$_SESSION['error_alnum_login']."</div>";
                                        unset($_SESSION['error_alnum_login']);
                                    }
                                    if(isset($_SESSION['error_login_existing']))
                                    {
                                        echo "<div class='error'>".$_SESSION['error_login_existing']."</div>";
                                        unset($_SESSION['error_login_existing']);
                                    }
                                ?>
                            </label>

                            <!--field Password-->
                            <label>
                                <?php echo $lang['password']?>:
                                <input class="form__field" type="password" value="<?php
                                    if(isset($_SESSION['tmp_password']))
                                    {
                                        echo $_SESSION['tmp_password'];
                                    }
                                ?>" name="password" /><br />
                                <?php
                                    if(isset($_SESSION['error_password']))
                                    {
                                        echo "<div class='error'>".$_SESSION['error_password']."</div>";
                                        unset($_SESSION['error_password']);
                                    }
                                ?>
                            </label>

                            <!--field Confirm Password-->
                            <label>
                                <?php echo $lang['confirm_password']?>:
                                <input class="form__field" type="password" name="confirm_password" />
                            </label>

                            <!--field Date of birthday-->
                            <label>
                                <?php echo $lang['date_of_birth']?>:
                                <input class="form__field" type="date" value="<?php
                                    if(isset($_SESSION['tmp_date']))
                                        {
                                            echo $_SESSION['tmp_date'];
                                        }
                                ?>" name="date_of_birth" /><br />
                                <?php
                                    if(isset($_SESSION['error_date']))
                                    {
                                        echo "<div class='error'>".$_SESSION['error_date']."</div>";
                                        unset($_SESSION['error_date']);
                                    }
                                ?>
                            </label>

                            <!--photo-->
                            <label>
                                <?php echo $lang['photo']?>:<br />
                                <input id="add-file__real" class="form__field" type="file" name="photo" hidden="hidden" />
                                <button id="add-file__btn" class="form__btn button" type="button"><?php echo $lang['choose_file']?></button>
                                <span id="add-file__text" class="form__text"><?php echo $lang['no_file']?></span>
                                
                                <?php
                                    if(isset($_SESSION['error_photo']))
                                    {
                                        echo "<div class='error'>".$_SESSION['error_photo']."</div>";
                                        unset($_SESSION['error_photo']);
                                    }
                                ?>
                            </label>
                            
                            <input class="form__btn" type="submit" value="<?php echo $lang['save']?>" />
                        </form>
                    </div>
                </div>
            </main>

            <?php 
                include_once 'footer.php';
            ?>
        </div>  
        
        <!--JavaScript-->
        <script src="../js/common.js"></script>
    </body>
</html>