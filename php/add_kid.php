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
        <a href="dashboard_parent_kids.php"><?php echo $lang['back']?></a>
        
        <br /><br /><a href="add_kid.php?lang=en"><?php echo $lang['en']?></a>
        <a href="add_kid.php?lang=pl"><?php echo $lang['pl']?></a>
        
        <br /><br /><a href="./services/do_logout_parent.php"><?php echo $lang['logout']?></a>
        
        <br /><br /><form action="./services/do_add_kid.php" method="post" enctype = "multipart/form-data">
            
            <!--field Name-->
            <?php echo $lang['name']?>: <br /> <input type="text" value="<?php
                if(isset($_SESSION['tmp_name']))
                {
                    echo $_SESSION['tmp_name'];
                }
            ?>" name="name" /><br />
            <?php 
                if(isset($_SESSION['error_name']))
                {
                    echo "<div class='error'>".$_SESSION['error_name']."</div>";
                    unset($_SESSION['error_name']);
                }
            ?>
            
            <!--field Gender-->
            <?php echo $lang['gender']?>: <br /> <input type="radio" name="gender" value="boy"><?php echo $lang['boy']?>
                <input type="radio" name="gender" value="girl"><?php echo $lang['girl']?><br />
            <?php
                if(isset($_SESSION['error_gender']))
                {
                    echo "<div class='error'>".$_SESSION['error_gender']."</div>";
                    unset($_SESSION['error_gender']);
                }
            ?>
        
            
            <!--field Login-->
            Login: <br /> <input type="text" value="<?php
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
            
            
            <!--field Password-->
            <?php echo $lang['password']?>: <br /> <input type="password" value="<?php
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
            
            <!--field Confirm Password-->
            <?php echo $lang['confirm_password']?>: <br /> <input type="password" name="confirm_password" /><br />
            
            <!--field Date of birthday-->
            <?php echo $lang['date_of_birth']?>: <br /> <input type="date" value="<?php
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
            
            <!--photo-->
            <?php echo $lang['photo']?>: <br /> <input type="file" name="photo" /><br />
            <?php
                if(isset($_SESSION['error_photo']))
                {
                    echo "<div class='error'>".$_SESSION['error_photo']."</div>";
                    unset($_SESSION['error_photo']);
                }
            ?>
            
            <br /><input type="submit" value="<?php echo $lang['save']?>" />
            
        </form>
    </body>
</html>