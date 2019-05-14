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
                'lg_kid' => $this->langManager->getLangParams()['lg_kid'],
                'lg_login' => $this->langManager->getLangParams()['lg_login'],
                'kid_login' => $this->request->getPostParam('login') ?? $this->request->getSessionParam('form_login'),
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
        
        $this->request->addSessionParam('kid_login', $login);
        
        $kidModel = new KidModel(new DBDriver(DbConnection::getPDO()));
        $kid = $kidModel->login($login, $password);
        if($kid)
        {
            $this->request->addSessionParam(self::KID_KEY, $kid);
            $this->redirect('/gaintimeoff/kid/dashboard');
        }
        else
        {
            $this->request->addSessionParam(self::LOGIN_FALSE_KEY, true);
            $this->redirect('/gaintimeoff/kid/login');
        }
    }
    
    public function dashboardAction() 
    {
        $this->checkRequestMethod($this->request::METHOD_GET);
        
        if(!$this->request->getSessionParam(self::KID_KEY))
        {
            $this->redirect('/gaintimeoff/kid/login');
        }
        
        $this->title = 'Kid dashboard';
        $this->bodyId = 'kidDashboard';
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
        $this->redirect('/gaintimeoff');
    }
}