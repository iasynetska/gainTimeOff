<?php
        session_start();
	include_once "lang_config.php";
?>

<!DOCTYPE HTML>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Registration for parent</title>
        <script src='https://www.google.com/recaptcha/api.js?hl=<?php echo $lang['language']?>'></script>
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
        <a href="registration.php?lang=en"><?php echo $lang['en']?></a>
        <a href="registration.php?lang=pl"><?php echo $lang['pl']?></a><br /><br />

        <form action="./services/do_registration.php" method="post">
            
            <!--field NAME-->
            <?php echo $lang['name']?>: <br /> <input type="text" value="<?php
                if(isset($_SESSION['rem_name']))
                {
                    echo $_SESSION['rem_name'];
                    //unset($_SESSION['rem_name']);
                }
            ?>" name="name" /> <br />
            <?php 
                if(isset($_SESSION['error_empty_name']))
                {
                    echo "<div class='error'>".$_SESSION['error_empty_name']."</div>";
                    unset($_SESSION['error_empty_name']);
                }
                if(isset($_SESSION['error_name']))
                {
                    echo "<div class='error'>".$_SESSION['error_name']."</div>";
                    unset($_SESSION['error_name']);
                }
            ?>
            
            <!--field Login-->
            Login: <br /> <input type="text" value="<?php
                if(isset($_SESSION['rem_login']))
                {
                    echo $_SESSION['rem_login'];
                    //unset($_SESSION['rem_login']);
                }
            ?>" name="login" /> <br />
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
            ?>
            
            <!--field E-mail-->
            E-mail: <br /> <input type="email" value="<?php
                if(isset($_SESSION['rem_email']))
                {
                    echo $_SESSION['rem_email'];
                   //unset($_SESSION['rem_email']);
                }
            ?>" name="email" /> <br />
            <?php
                if(isset($_SESSION['error_email']))
                {
                    echo "<div class='error'>".$_SESSION['error_email']."</div>";
                    unset($_SESSION['error_email']);
                }
            ?>
            
            <!--field Password-->
            <?php echo $lang['password']?>: <br /> <input type="password" value="<?php
                if(isset($_SESSION['rem_password']))
                {
                    echo $_SESSION['rem_password'];
                    //unset($_SESSION['rem_password']);
                }
            ?>" name="password" /> <br />
            <?php
                if(isset($_SESSION['error_password']))
                {
                    echo "<div class='error'>".$_SESSION['error_password']."</div>";
                    unset($_SESSION['error_password']);
                }
            ?>
            
            <!--field Confirm Password-->
            <?php echo $lang['confirm_password']?>: <br /> <input type="password" name="confirm_password" /> <br /><br />
            <?php
                if(isset($_SESSION['error_confirm_password']))
                {
                    echo "<div class='error'>".$_SESSION['error_confirm_password']."</div>";
                    unset($_SESSION['error_confirm_password']);
                }
            ?>
            
            <!--field Captcha-->
            <div class="g-recaptcha" data-sitekey="6Ld-SlUUAAAAAHdMdJ978xjc3D6LFXfsYwYnMEeS"></div> <br />
            <?php
                if(isset($_SESSION['error_robot']))
                {
                    echo "<div class='error'>".$_SESSION['error_robot']."</div>";
                    //unset($_SESSION['error_robot']);
                }
            ?>

            <input type="submit" value="<?php echo $lang['signup']?>" />
        </form>
    </body>
</html>