<?php
namespace controllers;

use core\DynamicJSProducer;
use models\KidModel;
use core\DBDriver;
use core\DbConnection;

class KidController extends Controller
{
    const LOGIN_FALSE_KEY = 'loginFalse';
    const KID_KEY = 'kid';
    
    public function loginAction()
    {
        $this->checkRequestMethod($this->request::METHOD_GET);
        
        $this->title = 'Kid login';
        $this->bodyId = 'kidLogin';
        $this->dynamicJS = DynamicJSProducer::produceJSLinks([DynamicJSProducer::JS_VALIDATE_FORM]);
        $this->content = $this->build(
            (dirname(__DIR__, 1)). '/views/kidLogin.html.php',
            [
                'lg_login' => $this->langManager->getLangParams()['lg_login'],
                'form_login' => $this->request->getPostParam('login'),
                'lg_kid' => $this->langManager->getLangParams()['lg_kid'],
                'lg_password' => $this->langManager->getLangParams()['lg_password'],
                'lg_error' => $this->request->getSessionParam(self::LOGIN_FALSE_KEY) ? $this->langManager->getLangParams()['lg_err_login_password'] : '',
                'lg_required_field' => $this->langManager->getLangParams()['lg_required_field'],
                'lg_login_submit' => $this->langManager->getLangParams()['lg_login_submit']
            ]
            );
        $this->request->removeSessionParam(self::LOGIN_FALSE_KEY);
    }
    
    public function doLoginAction()
    {
        $this->checkRequestMethod($this->request::METHOD_POST);
        
        $login = $this->request->getPostParam('login');
        $password = $this->request->getPostParam('password');
        
        $kidModel = new KidModel(new DBDriver(DbConnection::getPDO()));
        $kid = $kidModel->login($login, $password);
        if($kid)
        {
            $this->request->addSessionParam(self::KID_KEY, $kid);
            header('Location: /gaintimeoff/kid/dashboard');
            exit();
        }
        else
        {
            $this->request->addSessionParam(self::LOGIN_FALSE_KEY, true);
            header('Location: /gaintimeoff/kid/login');
            exit();
        }
    }
    
    public function dashboardAction() 
    {
        $this->checkRequestMethod($this->request::METHOD_GET);
        
        if(!$this->request->getSessionParam(self::KID_KEY))
        {
            header('Location: /gaintimeoff/kid/login');
            exit();
        }
        
        $this->title = 'Kid dashboard';
        $this->bodyId = 'dashboard_kid';
        $this->content = $this->build(
            (dirname(__DIR__, 1)). '/views/kidDashboard.html.php',
            [
                'helloKid' => $this->langManager->getLangParams()['lg_hello'] . ', ' . $this->request->getSessionParam(self::KID_KEY)->name,
                'lg_logout' => $this->langManager->getLangParams()['lg_logout'],
                'lg_time_to_play' => $this->langManager->getLangParams()['lg_time_to_play'],
                'kidMins' => $this->request->getSessionParam(self::KID_KEY)->mins_to_play
            ]
            );
    }
    
    public function logoutAction()
    {
        $this->request->removeSessionParam(self::KID_KEY);
        header('Location: /gaintimeoff');
        exit();
    }
}