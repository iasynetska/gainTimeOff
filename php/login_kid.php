<?php
    session_start();
    include_once "lang_config.php";
?>

<!DOCTYPE HTML>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Log in for kid</title>
    </head>
    <body>
        <a href="welcome.php"><img src="../img/logo.png" alt="logo" width="100px" height="100px" /></a><br />
        
        <a href="login_kid.php?lang=en"><?php echo $lang['en']?></a>
        <a href="login_kid.php?lang=pl"><?php echo $lang['pl']?></a><br /><br />

        <form action="login.php" method="post">
            Login: <br /> <input type="text" name="login" /> <br />
            <?php echo $lang['password']?>: <br /> <input type="password" name="password" /> <br /><br />
            <input type="submit" value="<?php echo $lang['login_submit']?>" /><br /><br />
        </form>
    </body>
</html>
