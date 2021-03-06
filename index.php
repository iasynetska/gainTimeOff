<?php 

use core\Request;
use core\LangManager;

//auto-load Classes
spl_autoload_register(function ($classname)
{
    require_once __DIR__ . DIRECTORY_SEPARATOR .'app' .DIRECTORY_SEPARATOR. str_replace('\\', DIRECTORY_SEPARATOR, $classname) . '.php';
});
session_start();

$uri = strtolower(explode('?', $_SERVER['REQUEST_URI'])[0]);
$uriParts = explode('/', $uri);
unset($uriParts[0]);
//if($uriParts[1] === 'gaintimeoff')
//{
//    unset($uriParts[1]);
//}
$uriParts = array_values($uriParts);

$controller = isset($uriParts[0]) && $uriParts[0] !== '' ? $uriParts[0] : 'homepage';

switch($controller)
{
    case 'homepage':
        $controller = 'HomePage';
        break;
    case 'parent':
        $controller = 'Parent';
        break;
    case 'kid':
        $controller = 'Kid';
        break;
    case 'kidblock':
        $controller = 'KidBlock';
        break;
    case 'restkid':
        $controller = 'RestKid';
        break;
    case 'restsubject':
        $controller = 'RestSubject';
        break;
    case 'restmark':
        $controller = 'RestMark';
        break;
    case 'resttask':
        $controller = 'RestTask';
        break;
    case 'resttime':
        $controller = 'RestTime';
        break;
    case 'message':
        $controller = 'Message';
        break;
    case 'timeblock':
        $controller = 'TimeBlock';
        break;
    case 'subjectblock':
        $controller = 'SubjectBlock';
        break;
    case 'markblock':
        $controller = 'MarkBlock';
        break;
    case 'taskblock':
        $controller = 'TaskBlock';
        break;
    case 'reportreceivedmarksblock':
        $controller = 'ReportReceivedMarksBlock';
        break;
        http_response_code(404);
        exit;
}

$controller = sprintf('\controllers\%sController', $controller);

$action = isset($uriParts[1]) && $uriParts[1] !== '' ? $uriParts[1] : 'index';
$actionParts = explode('-', $action);
for($i=1; $i<count($actionParts); $i++)
{
    $actionParts[$i] = ucfirst($actionParts[$i]);
}
$action = implode('', $actionParts);
$action = sprintf('%sAction', $action);

$request = new Request($_GET, $_POST, $_COOKIE, $_FILES);
$langManager = new LangManager($request);
$controller = new $controller($request, $langManager);
$controller->$action();

$controller->render();
