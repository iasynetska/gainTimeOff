<?php
	
    $lang = filter_input(INPUT_GET, 'lang');

    if(($lang==="en" || $lang==="pl") && $_SESSION['lang']!==$lang)
    {
        $_SESSION['lang'] = $lang;
    }
    else if (!isset($_SESSION['lang'])) 
    {
        $_SESSION['lang'] = "en";
    }

    require_once "languages/".$_SESSION['lang'].".php";