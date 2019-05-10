<?php
namespace controllers;

use core\DynamicJSProducer;

class ParentController extends Controller
{
    const LOGIN_FALSE_KEY = 'loginFalse';
    const PARENT_KEY = 'parent';
    
    public function loginAction()
    {
        $this->checkRequestMethod($this->request::METHOD_GET);
        
        $this->title = 'Parent login';
        $this->bodyId = 'parentLogin';
        $this->dynamicJS = DynamicJSProducer::produceJSLinks([DynamicJSProducer::JS_VALIDATE_FORM]);
        $this->content = $this->build(
            (dirname(__DIR__, 1)). '/views/parentLogin.html.php',
            [
                'lg_parent' => $this->langManager->getLangParams()['lg_parent'],
                'lg_login' => $this->langManager->getLangParams()['lg_login'],
                'parent_login' => $this->request->getPostParam('login') ? $this->request->getPostParam('login') : $this->request->getSessionParam('parent_login'),
                'lg_password' => $this->langManager->getLangParams()['lg_password'],
                'lg_error' => $this->request->getSessionParam(self::LOGIN_FALSE_KEY) ? $this->langManager->getLangParams()['lg_err_login_password'] : '',
                'lg_required_field' => $this->langManager->getLangParams()['lg_required_field'],
                'lg_login_submit' => $this->langManager->getLangParams()['lg_login_submit'],
                'lg_link_registration' => $this->langManager->getLangParams()['lg_link_registration']
            ]
            );
        $this->request->removeSessionParam(self::LOGIN_FALSE_KEY);
    }
    
    public function registrationAction()
    {
        $this->checkRequestMethod($this->request::METHOD_GET);
        
        $this->title = 'Parent registration';
        $this->bodyId = 'registration';
        $this->dynamicJS = DynamicJSProducer::produceJSLinks(
            [
                sprintf(DynamicJSProducer::JS_RECAPTCHA, $this->langManager->getSelectedLang()),
                DynamicJSProducer::JS_VALIDATE_FORM, 
                DynamicJSProducer::JS_COMMON, 
                DynamicJSProducer::JS_JQUERY
            ]
        );
        $this->content = $this->build(
            (dirname(__DIR__, 1)). '/views/parentRegistration.html.php',
            [
                'lg_registration' => $this->langManager->getLangParams()['lg_registration'],
                'lg_name' => $this->langManager->getLangParams()['lg_name'],
                'lg_login' => $this->langManager->getLangParams()['lg_login'],
                'lg_email' => $this->langManager->getLangParams()['lg_email'],
                'lg_password' => $this->langManager->getLangParams()['lg_password'],
                'lg_confirm_password' => $this->langManager->getLangParams()['lg_confirm_password'],
                'lg_not_robot' => $this->langManager->getLangParams()['lg_not_robot'],
                'lg_required_field' => $this->langManager->getLangParams()['lg_required_field'],
                'lg_signup' => $this->langManager->getLangParams()['lg_signup'],
                'lg_link_login' => $this->langManager->getLangParams()['lg_link_login']
            ]
            );
    }
    
    public function doLoginAction()
    {
        $this->checkRequestMethod($this->request::METHOD_POST);
        
        $login = $this->request->getPostParam('login');
        $password = $this->request->getPostParam('password');
        
        $this->request->addSessionParam('parent_login', $login);
        
        $parentModel = new ParentModel(new DBDriver(DbConnection::getPDO()));
        $parent = $parentModel->login($login, $password);
        if($parent)
        {
            $this->request->addSessionParam(self::PARENT_KEY, $parent);
            header('Location: /gaintimeoff/parent/dashboard');
            exit();
        }
        else
        {
            $this->request->addSessionParam(self::LOGIN_FALSE_KEY, true);
            header('Location: /gaintimeoff/parent/login');
            exit();
        }
    }
    
    public function dashboardAction()
    {
        $this->checkRequestMethod($this->request::METHOD_GET);
        
        if(!$this->request->getSessionParam(self::PARENT_KEY))
        {
            header('Location: /gaintimeoff/parent/login');
            exit();
        }
        
        $this->title = 'Parent dashboard';
        $this->bodyId = 'dashboard_parent';
        $this->content = $this->build(
            (dirname(__DIR__, 1)). '/views/parentDashboard.html.php',
            [
                'top_menu' => $this->buildTopMenu()
            ]
            );
    }
    
    public function buildTopMenu($param) {
        ;
    }
}