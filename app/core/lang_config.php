<?php
    
require_once 'appConfiguration.php';	

$lang = filter_input(INPUT_GET, 'lang');

if(($lang==='en' || $lang==='pl') && $_SESSION['lang']!==$lang)
{
    $_SESSION['lang'] = $lang;
}
else if (!isset($_SESSION['lang'])) 
{
    $_SESSION['lang'] = "en";
}

require_once $GLOBALS['_BASE_PATH_'] . "languages/".$_SESSION['lang'].".php";