<!DOCTYPE HTML>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">
        
        <title><?=$title?></title>
        
        <!--Bootstrap Grid CSS & CSS-->
        <link rel="stylesheet" type="text/css" href="/bootstrap/bootstrap-grid.min.css"/>
        
        <!--Fonts Awesome-->
<!--        <link rel="stylesheet" href="../libs/font-awesome/css/fontawesome.min.css"/>-->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
        
        <!--Adding Fonts-->
        <link rel="stylesheet" type="text/css" href="/css/fonts.css"/>
        
        <!--Custom styles for this template-->
        <link rel="stylesheet" type="text/css" href="/css/style.css"/>
    </head>
    
    <body id="<?=$bodyId?>" onload="<?=$jsFunction?>">
        <div class="wrapper d-flex flex-column">
			<?=$header?>
			<?=$content?>
			<?=$footer?>
        </div>
        <?=$dynamicJS?>
    </body>
</html>