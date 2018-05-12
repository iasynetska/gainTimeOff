<?php
    session_start();
    include_once "lang_config.php";
?>

<!DOCTYPE HTML>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Welcome</title>
    </head>
    <body>
        <a href="welcome.php?lang=en"><?php echo $lang['en']?></a>
        <a href="welcome.php?lang=pl"><?php echo $lang['pl']?></a><br /><br />
        <a href="login_parent.php"><?php echo $lang['parent']?></a>
        <a href="login_kid.php"><?php echo $lang['kid']?></a>
    </body>
</html>