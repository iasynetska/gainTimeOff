<?php
    session_start();
    include_once "lang_config.php";
?>

<!DOCTYPE HTML>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">
        
        <title>Welcome</title>
        
        <!--Bootstrap Grid CSS & CSS-->
        <link rel="stylesheet" type="text/css" href="../bootstrap/bootstrap-grid.min.css"/>
        
        <!--Fonts Google Almendra-->
        <link href="https://fonts.googleapis.com/css?family=Almendra:400,700&amp;subset=latin-ext" rel="stylesheet">
        
        <!--Custom styles for this template-->
        <link rel="stylesheet" href="../css/main.css"/>
    </head>
    
    <body>
        <header>
            <nav class="top-nav">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col top-nav_logo">
                            <a href="welcome.php">TimeToGain</a>
                        </div>
                        <div class="col">
                            <ul class="top-nav_lang justify-content-end">
                                <li>
                                    <a class="nav-link english" href="welcome.php?lang=en"><?php echo $lang['en']?></a>
                                </li>
                                <li>
                                    <div class="nav-slash">|</div>
                                </li>
                                <li>
                                    <a class="nav-link polish" href="welcome.php?lang=pl"><?php echo $lang['pl']?></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </nav>
        </header>
        
        <section class="user">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-auto kid">
                        <div class="card">
                            <div class="card-header"  onclick="location.href='login_kid.php';">
                                <a class="nav-link" href="login_kid.php"><?php echo $lang['kid']?></a>
                            </div>
                            <div class="card-body" onclick="location.href='login_kid.php';">
                                <img src="../img/children_white.png" alt="kid">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-auto parent">
                        <div class="card">
                            <div class="card-header" onclick="location.href='login_parent.php';">
                                <a class="nav-link" href="login_parent.php"><?php echo $lang['parent']?></a>
                            </div>
                            <div class="card-body" onclick="location.href='login_parent.php';">
                                <img src="../img/couple_white.png" alt="parent">
                            </div>
                        </div>
                    </div>
                </div>  
            </div>
        </section>
        
        <footer class="footer">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="counter">
                            <p><?php echo $lang['visitors']?>:  
                                <?php 
                                    include_once "./services/do_visitor_counter.php";
                                    if(($count = getCounter()) !== false)
                                    {
                                        echo $count;
                                    }
                                    else
                                    {
                                        echo 'unknown';
                                    }
                                ?>
                            </p>
                        </div>
                    </div>
                    <div class="col">
                        <div class="copy">
                            <p>&copy;2018 Viktoriia Iasynetska</p>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        

        <!--Bootstrap core Javascript-->
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
        <script>window.jQuery || document.write('<script src="../js/jquery-3.2.1.slim.min.js"><\/script>')</script>
    </body>
</html>