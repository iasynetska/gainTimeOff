<?php
    session_start();
    include_once "lang_config.php";
?>

<!DOCTYPE HTML>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Log in for parent</title>
        <style>
            .error
            {
                color:red;
                margin-bottom: 10px;
            }
	</style>
    </head>
    <body>
        <a href="login_parent.php?lang=en"><?php echo $lang['en']?></a>
        <a href="login_parent.php?lang=pl"><?php echo $lang['pl']?></a><br /><br />

        <form action="./services/do_login_parent.php" method="post">
            Login: <br /> <input type="text" value="<?php
                if(isset($_SESSION['rem_login']))
                {
                    echo $_SESSION['rem_login'];
                    unset($_SESSION['rem_login']);
                }
                ?>" name="login" /> <br />
            <?php echo $lang['password']?>: <br /> <input type="password" name="password" /> <br /><br />
            <?php
                if(isset($_SESSION['error_login_password']))
                {
                    echo "<div class='error'>".$_SESSION['error_login_password']."</div>";
                    unset($_SESSION['error_login_password']);
                }
            ?>
            <input type="submit" value="<?php echo $lang['login_submit']?>" /><br /><br />

            <a href="registration.php"><?php echo $lang['login_parent_link']?></a>
        </form>
    </body>
</html>