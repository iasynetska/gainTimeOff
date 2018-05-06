<?php
    session_start();
    include_once "lang_config.php";
?>

<!DOCTYPE HTML>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Greeting</title>
    </head>
    <body>
        <a href="greeting.php?lang=en"><?php echo $lang['en']?></a>
        <a href="greeting.php?lang=pl"><?php echo $lang['pl']?></a><br /><br />
        
        <p><?php echo sprintf($lang['greeting'], $_SESSION['name'])?></p>
    </body>
</html>