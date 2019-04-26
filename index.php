<?php 

use core\Request;
use core\LangManager;

//auto-load Classes
spl_autoload_register(function ($classname)
{
    require_once __DIR__ . DIRECTORY_SEPARATOR .'app' .DIRECTORY_SEPARATOR. str_replace('\\', DIRECTORY_SEPARATOR, $classname) . '.php';
});
session_start();

$uri = explode('?', $_SERVER['REQUEST_URI'])[0];
$uriParts = explode('/', $uri);
unset($uriParts[0]);
if(strcasecmp($uriParts[1], 'gaintimeoff') == 0)
{
    unset($uriParts[1]);
}
$uriParts = array_values($uriParts);

$controller = isset($uriParts[0]) && $uriParts[0] !== '' ? $uriParts[0] : 'main';

switch(strtolower($controller))
{
    case 'main':
        $controller = 'Main';
        break;
    case 'parent':
        $controller = 'Parent';
        break;
    case 'kid':
        $controller = 'Kid';
        break;
    default:
        echo 'Page not found';
        break;
}

$controller = sprintf('\controllers\%sController', $controller);

$action = isset($uriParts[1]) && $uriParts[1] !== '' ? $uriParts[1] : 'index';
$action = sprintf('%sAction', $action);

$request = new Request($_GET, $_POST, $_SERVER, $_COOKIE, $_FILES, $_SESSION);
$lang = new LangManager($request);
$controller = new $controller($request, $lang);
$controller->$action();

$controller->render();