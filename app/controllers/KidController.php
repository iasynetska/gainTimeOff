<?php
namespace controllers;

use core\DBDriver;
use core\DbConnection;
use core\DynamicJSProducer;
use core\Exceptions\ValidatorException;
use core\TimeConverter;
use models\KidModel;

class KidController extends HtmlController
{
    const LOGIN_FALSE_KEY = 'loginFalse';
    const KID_KEY = 'kid';
    
    public function loginAction()
    {
        $this->checkRequestMethod($this->request::METHOD_GET);
        
        $this->title = 'Kid login';
        $this->bodyId = 'kidLogin';
        $this->dynamicJS = DynamicJSProducer::produceJSLinks([DynamicJSProducer::JS_COMMON]);
        $this->content = $this->build(
            (dirname(__DIR__, 1)). '/views/kidLogin.html.php',
            [
                'lg_kid' => $this->langManager->getLangParams()['lg_kid'],
                'lg_login' => $this->langManager->getLangParams()['lg_login'],
                'kid_login' => $this->request->getSessionParam('kid_login') ?? '',
                'lg_password' => $this->langManager->getLangParams()['lg_password'],
                'lg_error' => $this->request->getSessionParam(self::LOGIN_FALSE_KEY) ? $this->langManager->getLangParams()['lg_err_login_password'] : '',
                'lg_required_field' => $this->langManager->getLangParams()['lg_required_field'],
                'lg_login_submit' => $this->langManager->getLangParams()['lg_login_submit']
            ]
            );
        $this->request->deleteSessionParam(self::LOGIN_FALSE_KEY);
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
            $this->redirect('/kid/dashboard');
        }
        else
        {
            $this->request->addSessionParam(self::LOGIN_FALSE_KEY, true);
            $this->redirect('/kid/login');
        }
    }
    
    public function dashboardAction() 
    {
        $this->checkRequestMethod($this->request::METHOD_GET);
        
        if(!$this->request->getSessionParam(self::KID_KEY))
        {
            $this->redirect('/kid/login');
        }
        
        $this->title = 'Kid dashboard';
        $this->bodyId = 'kidPageDashboard';
        $this->content = $this->build(
            (dirname(__DIR__, 1)). '/views/kidPageDashboard.html.php',
            [
                'helloKid' => $this->langManager->getLangParams()['lg_hello'] . ', ' . $this->request->getSessionParam(self::KID_KEY)->name,
                'lg_logout' => $this->langManager->getLangParams()['lg_logout'],
                'lg_time_to_play' => $this->langManager->getLangParams()['lg_time_to_play'],
                'kidMins' => TimeConverter::convertSecondsToTimeFormat($this->request->getSessionParam(self::KID_KEY)->time_to_play)
            ]
            );
    }
    
    public function doAddingKidAction()
    {
        $this->checkRequestMethod($this->request::METHOD_POST);
        
        $name = $this->request->getPostParam('name');
        $gender = $this->request->getPostParam('gender');
        $login = $this->request->getPostParam('login');
        $password = $this->request->getPostParam('password');
        $date = $this->request->getPostParam('date_of_birth');
        $photoFile = $this->request->getFileParam('photo');
        
        $this->request->addSessionParam('kid_name', $name);
        $this->request->addSessionParam('kid_login', $login);
        $this->request->addSessionParam('date_of_birth', $date);
        
        $kidModel = new KidModel(new DBDriver(DbConnection::getPDO()));
        
        $parent = $this->request->getSessionParam('parent');
        
        try
        {
            $kidModel->saveKid([
                'name' => $name,
                'gender' => $gender,
                'login' => $login,
                'password' => $password,
                'date_of_birth' => $date,
                'photo' => $photoFile,
                'parent_id' => $parent->getId(),
                'time_to_play' => 0
            ]);
            
            $parent->resetKids();
            $this->redirect('/parent/dashboard');
        }
        catch (ValidatorException $e) 
        {
            $errors = $e->getErrors();
            $this->request->addSessionParam('errors', $errors);
            $this->redirect('/parent/adding-kid');
        }
        
        $this->request->deleteSessionParam('kid_name');
        $this->request->deleteSessionParam('kid_login');
        $this->request->deleteSessionParam('date_of_birth');
    }
    
    public function logoutAction()
    {
        $this->request->deleteSessionParam(self::KID_KEY);
        $this->redirect('/');
    }
}