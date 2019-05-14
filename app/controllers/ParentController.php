<?php
namespace controllers;

use core\DynamicJSProducer;
use models\ParentModel;
use core\DBDriver;
use core\DbConnection;
use models\KidModel;
use core\LangManager;

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
            $this->redirect('/gaintimeoff/parent/dashboard');
        }
        else
        {
            $this->request->addSessionParam(self::LOGIN_FALSE_KEY, true);
            $this->redirect('/gaintimeoff/parent/login');
        }
    }
    
    public function dashboardAction()
    {
        $this->checkRequestMethod($this->request::METHOD_GET);
        
        if(!$this->request->getSessionParam(self::PARENT_KEY))
        {
            $this->redirect('/gaintimeoff/parent/login');
        }
        
        $parent = $this->request->getSessionParam(self::PARENT_KEY);
        $kid = new KidModel(new DBDriver(DbConnection::getPDO()));
        $kids = $kid->getKidsByParent($parent);
                
        $this->title = 'Parent dashboard';
        $this->bodyId = 'parentDashboard';
        $this->dynamicJS = DynamicJSProducer::produceJSLinks([DynamicJSProducer::JS_COMMON]);
        
        if($kids)
        {
            $this->content = $this->build(
                (dirname(__DIR__, 1)). '/views/parentDashboardKids.html.php',
                [
                    'top_menu' => $this->buildTopMenu(),
                    'lg_my_kids' => $this->langManager->getLangParams()['lg_my_kids'],
                    'kidBlock' => $this->buildKidBlock($kids)
                ]
            );
        }
        else 
        {
            $this->content = $this->build(
                (dirname(__DIR__, 1)). '/views/parentDashboardStart.html.php',
                [
                    'top_menu' => $this->buildTopMenu(),
                    'lg_add_kid' => $this->langManager->getLangParams()['lg_add_kid']
                ]
            );
        }
    }
    
    private function buildTopMenu() 
    {
        return $this->build(
            (dirname(__DIR__, 1)). '/views/topMenu.html.php',
            [
                'lg_kids' => $this->langManager->getLangParams()['lg_kids'],
                'lg_add_kid' => $this->langManager->getLangParams()['lg_add_kid'],
                'helloParent' => $this->langManager->getLangParams()['lg_hello'] . ', ' . $this->request->getSessionParam(self::PARENT_KEY)->name,
                'lg_logout' => $this->langManager->getLangParams()['lg_logout']
            ]
            );
    }
    
    private function buildKidBlock(array $kids)
    {
        $kidBlock = '';
        $kidActive = '';
        
        foreach($kids as $kid)
        {
            $kid === reset($kids) ? $kidActive = 'active-profile' : $kidActive = '';
            $kidBlock .= $this->build(
                (dirname(__DIR__, 1)). '/views/kidBlock.html.php',
                [
                    'kidName' => $kid->name,
                    'kidActive' => $kidActive,
                    'pathPhoto' => $this->getPathPhoto($kid)
                ]
                );
        }
        return $kidBlock;
    }
    
    private function getPathPhoto($kid)
    {
        if($kid->photo === NULL)
        {
            return '/gaintimeoff/img/'.$kid->gender.'.png';
        }
        else 
        {
            return 'data:image/jpeg;base64,'.$kid->photo;
        }
    }
    
    public function addingKidAction()
    {
        $this->checkRequestMethod($this->request::METHOD_GET);
        
        if(!$this->request->getSessionParam(self::PARENT_KEY))
        {
            $this->redirect('/gaintimeoff/parent/login');
        }
        
        $this->title = 'Adding Kid';
        $this->bodyId = 'parentAddingKid';
        $this->dynamicJS = DynamicJSProducer::produceJSLinks([DynamicJSProducer::JS_VALIDATE_FORM]);
        $this->content = $this->build(
            (dirname(__DIR__, 1)). '/views/parentAddingKid.html.php',
            [
                'top_menu' => $this->buildTopMenu(),
                'lg_add_kid' => $this->langManager->getLangParams()['lg_add_kid'],
                'lg_name' => $this->langManager->getLangParams()['lg_name'],
                'lg_choose_option' => $this->langManager->getLangParams()['lg_choose_option'],
                'lg_boy' => $this->langManager->getLangParams()['lg_boy'],
                'lg_girl' => $this->langManager->getLangParams()['lg_girl'],
                'lg_login' => $this->langManager->getLangParams()['lg_login'],
                'lg_password' => $this->langManager->getLangParams()['lg_password'],
                'lg_confirm_password' => $this->langManager->getLangParams()['lg_confirm_password'],
                'lg_date_of_birth' => $this->langManager->getLangParams()['lg_date_of_birth'],
                'lg_photo' => $this->langManager->getLangParams()['lg_photo'],
                'lg_choose_file' => $this->langManager->getLangParams()['lg_choose_file'],
                'lg_required_field' => $this->langManager->getLangParams()['lg_required_field'],
                'lg_save' => $this->langManager->getLangParams()['lg_save']
            ]
        );
    }
    
    public function logoutAction()
    {
        $this->request->removeSessionParam(self::PARENT_KEY);
        $this->redirect('/gaintimeoff');
    }
}