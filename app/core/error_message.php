<?php

session_start();

include_once __DIR__ .  DIRECTORY_SEPARATOR . 'lang_config.php';


$errorName = filter_input(INPUT_GET, 'errorName');

if(isset($lang[$errorName]))
{
    echo $lang[$errorName];
}
else
{
    http_response_code(406);
    echo $lang['err_default'];
}