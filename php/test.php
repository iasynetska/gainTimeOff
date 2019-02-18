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

            <main class="dashboard d-flex">
                <nav class="nav-menu">
                    <ul>
                        <li><a href="#1">Один</a>
                        <li><a href="#2">Два</a>
                        <li><a href="#3">Три</a>
                        <li><a href="#4">Четыре</a>
                        <li><a href="#5">Пять</a>
                        <li><a href="#6">Шесть</a>
                        <li><a href="#7">Семь</a> 
                    </ul>
                </nav>
                
                <div class="dashboard-content d-flex flex-column">
                    <div class="content-header">
                        <div class="content-header__logout">
                            <?php
                                echo "<div class='logout-text'>".$lang['hello'].$parent->name."</div>";
                                echo"<div class='logout-link'><a href='./services/do_logout.php'>".$lang['logout']."</a></div>";
                            ?>
                        </div>
                    </div>
                    <div>
<!--                        Bacon ipsum dolor amet pancetta rump landjaeger, turkey sausage ribeye spare ribs pig beef beef ribs shankle shank ham hock picanha. Burgdoggen bresaola meatball, biltong strip steak fatback short ribs. Bacon salami fatback pork venison biltong, chuck tail meatloaf ground round beef jerky pork loin corned beef turducken. Burgdoggen tail boudin, porchetta capicola andouille landjaeger.

Pig filet mignon doner fatback boudin venison, cupim salami tongue. Venison filet mignon bacon pancetta turducken chuck shank meatball sirloin salami fatback ground round turkey. Pastrami filet mignon shank alcatra pig biltong sausage salami pork chop bresaola short ribs kielbasa landjaeger beef ribs. Hamburger fatback shoulder bresaola sirloin. Drumstick ground round meatball, shoulder salami flank filet mignon chicken cupim. Shankle pancetta salami landjaeger turkey picanha short loin swine brisket, buffalo kevin bacon kielbasa. Tenderloin turkey salami, bresaola ribeye jerky shank pig t-bone shankle tri-tip ham tongue venison sirloin.

Capicola ham hock spare ribs chuck tongue turkey. Shankle bresaola t-bone ham hock. Pork loin venison alcatra tail ham hock t-bone tri-tip landjaeger turkey andouille shoulder. Turducken short ribs kielbasa frankfurter, meatloaf bresaola chicken capicola shankle rump boudin drumstick beef.

Pork shankle sausage capicola pig andouille. Chuck alcatra andouille hamburger flank shank ham. Meatball rump kevin, ball tip spare ribs drumstick venison short ribs ham pancetta ham hock jerky. Cupim buffalo t-bone pancetta pork loin ground round alcatra jowl boudin sausage kielbasa bresaola brisket porchetta filet mignon.

Buffalo tongue kielbasa, kevin filet mignon sirloin beef ribs bacon pork belly ground round landjaeger leberkas shankle. Bresaola boudin chicken pig. Short loin filet mignon chicken capicola, ground round meatloaf pastrami boudin pork tongue buffalo hamburger tenderloin beef ribs jowl. Tenderloin tail frankfurter alcatra ham hock ball tip swine leberkas short ribs corned beef brisket chicken pork.

Andouille rump cupim landjaeger. Tongue pastrami bacon, jerky kevin jowl beef doner ham hock andouille short loin landjaeger flank sausage. Flank ham hock pork boudin meatloaf. Ground round pork belly pig burgdoggen, shankle boudin beef meatloaf porchetta tri-tip capicola filet mignon.

Venison brisket ham hock, porchetta salami chuck corned beef fatback. Boudin hamburger burgdoggen, doner drumstick chicken shank landjaeger tri-tip strip steak venison meatball. Leberkas burgdoggen short loin corned beef ball tip tri-tip kielbasa doner pork chop pork loin. Tail rump filet mignon fatback tongue pig kevin doner.

Alcatra fatback pork belly bresaola bacon biltong meatball landjaeger drumstick short loin cupim. Chicken frankfurter corned beef sausage ground round. Ground round ham hock chicken pork loin tri-tip pork. Pork chop prosciutto pastrami strip steak, venison tongue tenderloin turducken bresaola ribeye drumstick porchetta kielbasa. Kevin chicken short ribs ham. Bresaola boudin ham kielbasa bacon, short loin pork belly shankle pancetta t-bone turkey shank. Alcatra chicken pork loin shank ball tip, salami cow.

Sirloin spare ribs landjaeger porchetta tongue corned beef. Pork belly pork chop beef ribs strip steak. Turducken boudin biltong ground round ribeye brisket short loin ball tip tongue shoulder meatloaf kielbasa pastrami. Bresaola shank sirloin, filet mignon t-bone sausage tri-tip andouille tail ham hock pork loin alcatra.

Shank tongue biltong, sausage ham frankfurter cow tenderloin buffalo beef capicola flank. Salami sirloin filet mignon tenderloin, flank shoulder shank biltong pancetta rump porchetta buffalo chuck kielbasa. Picanha shank beef hamburger. Pig chuck corned beef turducken, ball tip cupim venison. Spare ribs jerky chuck salami flank, prosciutto shankle alcatra porchetta brisket. Frankfurter andouille brisket meatball short loin.

Does your lorem ipsum text long for something a little meatier? Give our generator a try… it’s tasty!

Bacon ipsum dolor amet pancetta rump landjaeger, turkey sausage ribeye spare ribs pig beef beef ribs shankle shank ham hock picanha. Burgdoggen bresaola meatball, biltong strip steak fatback short ribs. Bacon salami fatback pork venison biltong, chuck tail meatloaf ground round beef jerky pork loin corned beef turducken. Burgdoggen tail boudin, porchetta capicola andouille landjaeger.

Pig filet mignon doner fatback boudin venison, cupim salami tongue. Venison filet mignon bacon pancetta turducken chuck shank meatball sirloin salami fatback ground round turkey. Pastrami filet mignon shank alcatra pig biltong sausage salami pork chop bresaola short ribs kielbasa landjaeger beef ribs. Hamburger fatback shoulder bresaola sirloin. Drumstick ground round meatball, shoulder salami flank filet mignon chicken cupim. Shankle pancetta salami landjaeger turkey picanha short loin swine brisket, buffalo kevin bacon kielbasa. Tenderloin turkey salami, bresaola ribeye jerky shank pig t-bone shankle tri-tip ham tongue venison sirloin.

Capicola ham hock spare ribs chuck tongue turkey. Shankle bresaola t-bone ham hock. Pork loin venison alcatra tail ham hock t-bone tri-tip landjaeger turkey andouille shoulder. Turducken short ribs kielbasa frankfurter, meatloaf bresaola chicken capicola shankle rump boudin drumstick beef.

Pork shankle sausage capicola pig andouille. Chuck alcatra andouille hamburger flank shank ham. Meatball rump kevin, ball tip spare ribs drumstick venison short ribs ham pancetta ham hock jerky. Cupim buffalo t-bone pancetta pork loin ground round alcatra jowl boudin sausage kielbasa bresaola brisket porchetta filet mignon.

Buffalo tongue kielbasa, kevin filet mignon sirloin beef ribs bacon pork belly ground round landjaeger leberkas shankle. Bresaola boudin chicken pig. Short loin filet mignon chicken capicola, ground round meatloaf pastrami boudin pork tongue buffalo hamburger tenderloin beef ribs jowl. Tenderloin tail frankfurter alcatra ham hock ball tip swine leberkas short ribs corned beef brisket chicken pork.

Andouille rump cupim landjaeger. Tongue pastrami bacon, jerky kevin jowl beef doner ham hock andouille short loin landjaeger flank sausage. Flank ham hock pork boudin meatloaf. Ground round pork belly pig burgdoggen, shankle boudin beef meatloaf porchetta tri-tip capicola filet mignon.

Venison brisket ham hock, porchetta salami chuck corned beef fatback. Boudin hamburger burgdoggen, doner drumstick chicken shank landjaeger tri-tip strip steak venison meatball. Leberkas burgdoggen short loin corned beef ball tip tri-tip kielbasa doner pork chop pork loin. Tail rump filet mignon fatback tongue pig kevin doner.

Alcatra fatback pork belly bresaola bacon biltong meatball landjaeger drumstick short loin cupim. Chicken frankfurter corned beef sausage ground round. Ground round ham hock chicken pork loin tri-tip pork. Pork chop prosciutto pastrami strip steak, venison tongue tenderloin turducken bresaola ribeye drumstick porchetta kielbasa. Kevin chicken short ribs ham. Bresaola boudin ham kielbasa bacon, short loin pork belly shankle pancetta t-bone turkey shank. Alcatra chicken pork loin shank ball tip, salami cow.

Sirloin spare ribs landjaeger porchetta tongue corned beef. Pork belly pork chop beef ribs strip steak. Turducken boudin biltong ground round ribeye brisket short loin ball tip tongue shoulder meatloaf kielbasa pastrami. Bresaola shank sirloin, filet mignon t-bone sausage tri-tip andouille tail ham hock pork loin alcatra.

Shank tongue biltong, sausage ham frankfurter cow tenderloin buffalo beef capicola flank. Salami sirloin filet mignon tenderloin, flank shoulder shank biltong pancetta rump porchetta buffalo chuck kielbasa. Picanha shank beef hamburger. Pig chuck corned beef turducken, ball tip cupim venison. Spare ribs jerky chuck salami flank, prosciutto shankle alcatra porchetta brisket. Frankfurter andouille brisket meatball short loin.

Does your lorem ipsum text long for something a little meatier? Give our generator a try… it’s tasty!-->
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