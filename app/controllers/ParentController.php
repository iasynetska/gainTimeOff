<?php
namespace controllers;

use core\DBDriver;
use core\DbConnection;
use core\DynamicJSProducer;
use core\Exceptions\ValidatorException;
use core\TimeConverter;
use models\ParentModel;
use models\entities\UserKid;
use models\ReportReceivedMarksModel;

class ParentController extends HtmlController
{
    const LOGIN_FALSE_KEY = 'loginFalse';
    const PARENT_KEY = 'parent';
    
    public function loginAction()
    {
        $this->checkRequestMethod($this->request::METHOD_GET);
        
        $this->title = 'Parent login';
        $this->bodyId = 'parentLogin';
        $this->dynamicJS = DynamicJSProducer::produceJSLinks([DynamicJSProducer::JS_COMMON]);
        $this->content = $this->build(
            (dirname(__DIR__, 1)). '/views/parentLogin.html.php',
            [
                'lg_parent' => $this->langManager->getLangParams()['lg_parent'],
                'lg_login' => $this->langManager->getLangParams()['lg_login'],
                'parent_login' => $this->request->getSessionParam('parent_login') ?? '',
                'lg_password' => $this->langManager->getLangParams()['lg_password'],
                'lg_error' => $this->request->getSessionParam(self::LOGIN_FALSE_KEY) ? $this->langManager->getLangParams()['lg_err_login_password'] : '',
                'lg_required_field' => $this->langManager->getLangParams()['lg_required_field'],
                'lg_login_submit' => $this->langManager->getLangParams()['lg_login_submit'],
                'lg_link_registration' => $this->langManager->getLangParams()['lg_link_registration']
            ]
            );
        $this->request->deleteSessionParam(self::LOGIN_FALSE_KEY);
    }
    
    public function registrationAction()
    {
        $this->checkRequestMethod($this->request::METHOD_GET);
        $this->title = 'Parent registration';
        $this->bodyId = 'registration';
        $this->dynamicJS = DynamicJSProducer::produceJSLinks(
            [
                sprintf(DynamicJSProducer::JS_RECAPTCHA, $this->langManager->getSelectedLang()),
                DynamicJSProducer::JS_COMMON, 
                DynamicJSProducer::JS_JQUERY
            ]
        );
        $this->content = $this->build(
            (dirname(__DIR__, 1)). '/views/parentRegistration.html.php',
            [
                'lg_registration' => $this->langManager->getLangParams()['lg_registration'],
                'lg_name' => $this->langManager->getLangParams()['lg_name'],
                'parent_name' => $this->request->getSessionParam('parent_name') ?? '',
                'error_name' => isset($this->request->getSessionParam('errors')['name']) ? $this->buildMessage($this->request->getSessionParam('errors')['name']) : '',
                'lg_login' => $this->langManager->getLangParams()['lg_login'],
                'parent_login' => $this->request->getSessionParam('parent_login') ?? '',
                'error_login' => isset($this->request->getSessionParam('errors')['login']) ? $this->buildMessage($this->request->getSessionParam('errors')['login']) : '',
                'lg_email' => $this->langManager->getLangParams()['lg_email'],
                'parent_email' => $this->request->getSessionParam('parent_email') ?? '',
                'error_email' => isset($this->request->getSessionParam('errors')['email']) ? $this->buildMessage($this->request->getSessionParam('errors')['email']) : '',
                'lg_password' => $this->langManager->getLangParams()['lg_password'],
                'parent_password' => $this->request->getSessionParam('parent_password') ?? '',
                'lg_confirm_password' => $this->langManager->getLangParams()['lg_confirm_password'],
                'error_password' => isset($this->request->getSessionParam('errors')['password']) ? $this->buildMessage($this->request->getSessionParam('errors')['password']) : '',
                'error_confirm_password' => '',
                'lg_not_robot' => $this->langManager->getLangParams()['lg_not_robot'],
                'error_reCaptcha' => isset($this->request->getSessionParam('errors')['g-recaptcha-response']) ? $this->buildMessage($this->request->getSessionParam('errors')['g-recaptcha-response']) : '',
                'lg_required_field' => $this->langManager->getLangParams()['lg_required_field'],
                'lg_signup' => $this->langManager->getLangParams()['lg_signup'],
                'lg_link_login' => $this->langManager->getLangParams()['lg_link_login']
            ]
            );
        $this->request->deleteSessionParam(self::LOGIN_FALSE_KEY);
        $this->request->deleteSessionParam(self::PARENT_KEY);
        $this->request->deleteSessionParam('errors');
        $this->request->deleteSessionParam('parent_name');
        $this->request->deleteSessionParam('parent_login');
        $this->request->deleteSessionParam('parent_email');
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
            $this->redirect('/parent/dashboard');
        }
        else
        {
            $this->request->addSessionParam(self::LOGIN_FALSE_KEY, true);
            $this->redirect('/parent/login');
        }
    }
    
    public function doRegistrationAction()
    {
        $this->checkRequestMethod($this->request::METHOD_POST);
        
        $name = $this->request->getPostParam('name');
        $login = $this->request->getPostParam('login');
        $email = $this->request->getPostParam('email');
        $password = $this->request->getPostParam('password');
        $reCaptchaResponse = $this->request->getPostParam('g-recaptcha-response');
        
        $this->request->addSessionParam('parent_name', $name);
        $this->request->addSessionParam('parent_login', $login);
        $this->request->addSessionParam('parent_email', $email);
        
        $parentModel = new ParentModel(new DBDriver(DbConnection::getPDO()));

        try 
        {            
            $parentModel->saveParent([
                'name' => $name,
                'login' => $login,
                'email' => $email,
                'password' => $password,
                'g-recaptcha-response' => $reCaptchaResponse
            ]);

            $this->redirect('/parent/greeting');
        } 
        catch (ValidatorException $e) 
        {
            $errors = $e->getErrors();
            $this->request->addSessionParam('errors', $errors);
            $this->redirect('/parent/registration');
        }     
    }
    
    public function greetingAction()
    {
        $this->checkRequestMethod($this->request::METHOD_GET);
        
        $this->title = 'Greeting';
        $this->bodyId = 'greeting';
        
        $this->content = $this->build(
            (dirname(__DIR__, 1)). '/views/parentGreeting.html.php',
            [
                'lg_greeting' => $this->langManager->getLangParams()['lg_greeting'],
                'parentName' => $this->request->getSessionParam('parent_name'),
                'lg_login_form' => $this->langManager->getLangParams()['lg_login_form'],
            ]
            );
    }
    
    public function dashboardAction()
    {
        $this->checkRequestMethod($this->request::METHOD_GET);
        
        if(!$this->request->getSessionParam(self::PARENT_KEY))
        {
            $this->redirect('/parent/login');
        }
        
        $parent = $this->request->getSessionParam(self::PARENT_KEY);  
        
        $this->title = 'Parent dashboard';
        $this->bodyId = 'parentDashboard';
        $this->jsFunction = 'getFirstKidBlocks()';
        $this->dynamicJS = DynamicJSProducer::produceJSLinks([DynamicJSProducer::JS_COMMON]);
        $kids = $parent->getKids();
        
        if($kids)
        {
            $this->content = $this->build(
                (dirname(__DIR__, 1)). '/views/parentDashboardKids.html.php',
                [
                    'top_menu' => $this->buildTopMenu(),
                    'kidsTitle' => $this->langManager->getLangParams()['lg_my_kids'],
                    'kidBlock' => $this->buildDashboardKidBlock($kids),
                    'dashboardTimeBlock' => $this->buildDashboardTimeBlock(reset($kids)),
                    'dashboardSubjectBlock' => $this->buildDashboardSubjectBlock(reset($kids)),
                    'dashboardTaskBlock' => $this->buildDashboardTaskBlock(reset($kids)),
                    'dashboardReportReceivedMarksBlock' => $this->buildDashboardReportReceivedMarksBlock(reset($kids))
                ]
            );
        }
        else 
        {
            $this->content = $this->build(
                (dirname(__DIR__, 1)). '/views/parentDashboardStart.html.php',
                [
                    'top_menu' => $this->buildTopMenu(),
                    'kidAdd' => $this->langManager->getLangParams()['lg_add_kid']
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
    
    protected function buildDashboardKidBlock(array $kids)
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
    
    protected function buildDashboardTimeBlock(UserKid $kid) 
    {
        $kidTimeBlock = $this->build(
            (dirname(__DIR__, 1)). '/views/kidTimeBlock.html.php',
            [
                'lg_time_to_play' => $this->langManager->getLangParams()['lg_time_to_play'],
                'kidTime' => TimeConverter::convertSecondsToTimeFormat($kid->time_to_play),
                'lg_time_played' => $this->langManager->getLangParams()['lg_time_played'],
                'kidName' => $kid->name
            ]
            );
        return $kidTimeBlock;
    }
    
    protected function buildDashboardSubjectBlock(UserKid $kid)
    {
        $kidSubjectBlock = $this->build(
            (dirname(__DIR__, 1)). '/views/kidSubjectBlock.html.php',
            [
                'lg_school_subjects' => $this->langManager->getLangParams()['lg_school_subjects'],
                'subjects' => $kid->getKidSubjects(),
                'marks' => $kid->getKidMarks(),
                'kidName' => $kid->name,
                'lg_create_new' =>$this->langManager->getLangParams()['lg_create_new'],
                'lg_add_subjects_title' => $this->langManager->getLangParams()['lg_add_subjects_title'],
                'lg_select_subject' => $this->langManager->getLangParams()['lg_select_subject'],
                'lg_add_marks_title' => $this->langManager->getLangParams()['lg_add_marks_title'],
                'lg_select_mark' => $this->langManager->getLangParams()['lg_select_mark'],
                'lg_save' => $this->langManager->getLangParams()['lg_save']
            ]
            );
        return $kidSubjectBlock;
    }
    
    protected function buildDashboardTaskBlock(UserKid $kid)
    {
        $kidTaskBlock = $this->build(
            (dirname(__DIR__, 1)). '/views/kidTaskBlock.html.php',
            [
                'lg_tasks' => $this->langManager->getLangParams()['lg_tasks'],
                'tasks' => $kid->getKidTasks(),
                'kidName' => $kid->name,
                'lg_create_new' =>$this->langManager->getLangParams()['lg_create_new'],
                'lg_select_task' => $this->langManager->getLangParams()['lg_select_task'],
                'lg_save' => $this->langManager->getLangParams()['lg_save']
            ]
            );
        return $kidTaskBlock;
    }

    protected function buildDashboardReportReceivedMarksBlock(UserKid $kid, String $startDate = "", String $endDate = "")
    {
        $startDate = $startDate === "" ? date("Y") . "-01-01" : $startDate;
        $endDate = $endDate === "" ? date("Y") + 1 . "-01-01" : $endDate;

        $reportReceivedMarksModel = new ReportReceivedMarksModel(new DBDriver(DbConnection::getPDO()));
        $kidReportReceivedMarksBlock = $this->build(
            (dirname(__DIR__, 1)) . '/views/kidReportReceivedMarksBlock.html.php',
            [
                'lg_select_month' => $this->langManager->getLangParams()['lg_select_month'],
                'lg_name_months' => $this->langManager->getLangParams()['lg_name_months'],
                'lg_select_year' => $this->langManager->getLangParams()['lg_select_year'],
                'kidName' => $kid->name,
                'lg_marks' => $this->langManager->getLangParams()['lg_marks'],
                'receivedMarks' => $reportReceivedMarksModel->getReportReceivedMarks($kid, $startDate, $endDate)
            ]
        );
        return $kidReportReceivedMarksBlock;
    }
    
    private function getPathPhoto($kid)
    {
        if($kid->photo === NULL)
        {
            return '/img/'.$kid->gender.'.png';
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
            $this->redirect('/parent/login');
        }
        
        $this->title = 'Adding Kid';
        $this->bodyId = 'parentAddingKid';
        $this->dynamicJS = DynamicJSProducer::produceJSLinks([DynamicJSProducer::JS_COMMON]);
        $this->content = $this->build(
            (dirname(__DIR__, 1)). '/views/parentAddingKid.html.php',
            [
                'top_menu' => $this->buildTopMenu(),
                'lg_add_kid' => $this->langManager->getLangParams()['lg_add_kid'],
                'lg_name' => $this->langManager->getLangParams()['lg_name'],
                'kid_name' => $this->request->getSessionParam('kid_name') ?? '',
                'error_name' => isset($this->request->getSessionParam('errors')['name']) ? $this->buildMessage($this->request->getSessionParam('errors')['name']) : '',
                'lg_choose_option' => $this->langManager->getLangParams()['lg_choose_option'],
                'lg_boy' => $this->langManager->getLangParams()['lg_boy'],
                'lg_girl' => $this->langManager->getLangParams()['lg_girl'],
                'error_gender' => isset($this->request->getSessionParam('errors')['gender']) ? $this->buildMessage($this->request->getSessionParam('errors')['gender']) : '',
                'lg_login' => $this->langManager->getLangParams()['lg_login'],
                'kid_login' => $this->request->getSessionParam('kid_login') ?? '',
                'error_login' => isset($this->request->getSessionParam('errors')['login']) ? $this->buildMessage($this->request->getSessionParam('errors')['login']) : '',
                'lg_password' => $this->langManager->getLangParams()['lg_password'],
                'error_password' => isset($this->request->getSessionParam('errors')['password']) ? $this->buildMessage($this->request->getSessionParam('errors')['password']) : '',
                'lg_confirm_password' => $this->langManager->getLangParams()['lg_confirm_password'],
                'lg_date_of_birth' => $this->langManager->getLangParams()['lg_date_of_birth'],
                'date_of_birth' => $this->request->getSessionParam('date_of_birth') ?? '',
                'error_date_of_birth' => isset($this->request->getSessionParam('errors')['date_of_birth']) ? $this->buildMessage($this->request->getSessionParam('errors')['date_of_birth']) : '',
                'lg_photo' => $this->langManager->getLangParams()['lg_photo'],
                'lg_choose_file' => $this->langManager->getLangParams()['lg_choose_file'],
                'error_photo' => isset($this->request->getSessionParam('errors')['photo']) ? $this->buildMessage($this->request->getSessionParam('errors')['photo']) : '',
                'lg_required_field' => $this->langManager->getLangParams()['lg_required_field'],
                'lg_save' => $this->langManager->getLangParams()['lg_save']
            ]
            );
        $this->request->deleteSessionParam('errors');
        $this->request->deleteSessionParam('kid_name');
        $this->request->deleteSessionParam('kid_login');
        $this->request->deleteSessionParam('date_of_birth');
    }
    
    
    public function addingSubjectsMarksAction()
    {
        $this->checkRequestMethod($this->request::METHOD_GET);
        
        if(!$this->request->getSessionParam(self::PARENT_KEY))
        {
            $this->redirect('/parent/login');
        }
        
        $this->dynamicJS = DynamicJSProducer::produceJSLinks([DynamicJSProducer::JS_COMMON]);
        
        $kidName = $this->request->getGetParam('kidName');
        $kid = $this->request->getSessionParam(self::PARENT_KEY)->getKids()[$kidName];
        
        $this->title = 'Adding Subjects and Marks';
        $this->bodyId = 'parentAddingSubjects';
        
        $this->content = $this->build(
            (dirname(__DIR__, 1)). '/views/parentAddingSubjectsMarks.html.php',
            [
                'top_menu' => $this->buildTopMenu(),
                'titleSubject' => $this->langManager->getLangParams()['lg_subjects_title'],
                'kidName' => $kid->name,
                'pathPhoto' => $this->getPathPhoto($kid),
                'subjectBlock' => $this->buildAddingSubjectBlock($kid),
                'markBlock' => $this->buildAddingMarkBlock($kid),
            ]
            );
        $this->request->deleteSessionParam('errors');
    }
    
    protected function buildAddingSubjectBlock($kid)
    {
        $kidSubjectsBlock = $this->build(
            (dirname(__DIR__, 1)). '/views/subjectBlock.html.php',
            [
                'lg_add_subjects_title' => $this->langManager->getLangParams()['lg_add_subjects_title'],
                'lg_new_subject' => $this->langManager->getLangParams()['lg_new_subject'],
                'error_subject' => isset($this->request->getSessionParam('errors')['subject']) ? $this->buildMessage($this->request->getSessionParam('errors')['subject']) : '',
                'lg_school_subjects' => $this->langManager->getLangParams()['lg_school_subjects'],
                'subjects' => $kid->getKidSubjects(),
                'lg_sub_exist' => $this->langManager->getLangParams()['lg_sub_exist'],
                'kidName' => $kid->name,
                'lg_save' => $this->langManager->getLangParams()['lg_save']
            ]
            );
        return $kidSubjectsBlock;
    }
    
    protected function buildAddingMarkBlock($kid)
    {
        $markBlock = $this->build(
            (dirname(__DIR__, 1)). '/views/markBlock.html.php',
            [
                'lg_add_marks_title' => $this->langManager->getLangParams()['lg_add_marks_title'],
                'lg_new_mark' => $this->langManager->getLangParams()['lg_new_mark'],
                'error_mark' => isset($this->request->getSessionParam('errors')['mark']) ? $this->buildMessage($this->request->getSessionParam('errors')['mark']) : '',
                'marks' => $kid->getKidMarks(),
                'lg_mark_exist' => $this->langManager->getLangParams()['lg_mark_exist'],
                'kidName' => $kid->name,
                'lg_save' => $this->langManager->getLangParams()['lg_save'],
            ]
            );
        return $markBlock;
    }
    
    public function addingTasksAction()
    {
        $this->checkRequestMethod($this->request::METHOD_GET);
        
        if(!$this->request->getSessionParam(self::PARENT_KEY))
        {
            $this->redirect('/parent/login');
        }
        
        $this->dynamicJS = DynamicJSProducer::produceJSLinks([DynamicJSProducer::JS_COMMON]);
        
        $kidName = $this->request->getGetParam('kidName');
        $kid = $this->request->getSessionParam(self::PARENT_KEY)->getKids()[$kidName];
        
        $this->title = 'Adding Tasks';
        $this->bodyId = 'parentAddingTasks';
        
        $this->content = $this->build(
            (dirname(__DIR__, 1)). '/views/parentAddingTasks.html.php',
            [
                'top_menu' => $this->buildTopMenu(),
                'titleTasks' => $this->langManager->getLangParams()['lg_tasks_title'],
                'kidName' => $kid->name,
                'pathPhoto' => $this->getPathPhoto($kid),
                'taskBlock' => $this->buildAddingTaskBlock($kid),
                'lg_save' => $this->langManager->getLangParams()['lg_save']
            ]
            );
        $this->request->deleteSessionParam('errors');
    }
    
    protected function buildAddingTaskBlock($kid)
    {
        $taskBlock = $this->build(
            (dirname(__DIR__, 1)). '/views/taskBlock.html.php',
            [
                'lg_add_tasks_title' => $this->langManager->getLangParams()['lg_add_tasks_title'],
                'lg_new_task' => $this->langManager->getLangParams()['lg_new_task'],
                'error_task' => isset($this->request->getSessionParam('errors')['task']) ? $this->buildMessage($this->request->getSessionParam('errors')['task']) : '',
                'tasks' => $kid->getKidTasks(),
                'lg_task_exist' => $this->langManager->getLangParams()['lg_task_exist'],
                'kidName' => $kid->name,
                'lg_save' => $this->langManager->getLangParams()['lg_save']
            ]
            );
        return $taskBlock;
    }
    
    public function kidProfileSettingsAction()
    {
        $this->checkRequestMethod($this->request::METHOD_GET);
        
        if(!$this->request->getSessionParam(self::PARENT_KEY))
        {
            $this->redirect('/parent/login');
        }
        
        $this->dynamicJS = DynamicJSProducer::produceJSLinks([DynamicJSProducer::JS_COMMON]);
        
        $kidName = $this->request->getGetParam('kidName');
        $kid = $this->request->getSessionParam(self::PARENT_KEY)->getKids()[$kidName];
        
        $this->title = "Kid's settings";
        $this->bodyId = 'parentKidSettings';
        
        $this->content = $this->build(
            (dirname(__DIR__, 1)). '/views/parentKidProfile.html.php',
            [
                'top_menu' => $this->buildTopMenu(),
                'lg_kid_profile_settings' => $this->langManager->getLangParams()['lg_kid_profile_settings'],
                'kidName' => $kid->name,
                'pathPhoto' => $this->getPathPhoto($kid),
                'lg_personal_data' => $this->langManager->getLangParams()['lg_personal_data'],
                'lg_name' => $this->langManager->getLangParams()['lg_name'],
                'gender' => $kid->gender,
                'lg_login' => $this->langManager->getLangParams()['lg_login'],
                'kidLogin' => $kid->login,
                'lg_date_of_birth' => $this->langManager->getLangParams()['lg_date_of_birth'],
                'kidBirthday' => $kid->date_of_birth,
                'lg_photo_title' => $this->langManager->getLangParams()['lg_photo_title'],
                'lg_password' => $this->langManager->getLangParams()['lg_password'],
                'lg_time_to_play' => $this->langManager->getLangParams()['lg_time_to_play'],                
                'lg_time' => $this->langManager->getLangParams()['lg_time'],
                'kidTime' => TimeConverter::convertSecondsToTimeFormat($kid->time_to_play),
                'lg_school_subjects' => $this->langManager->getLangParams()['lg_school_subjects'],
                'lg_add_subjects_title' => $this->langManager->getLangParams()['lg_add_subjects_title'],
                'subjects' => $kid->getKidSubjects(),
                'lg_marks'=> $this->langManager->getLangParams()['lg_marks'],
                'lg_add_marks_title' => $this->langManager->getLangParams()['lg_add_marks_title'],
                'marks' => $kid->getKidMarks(),
                'lg_tasks' => $this->langManager->getLangParams()['lg_tasks'],
                'lg_add_tasks_title' => $this->langManager->getLangParams()['lg_add_tasks_title'],
                'tasks' => $kid->getKidTasks()
            ]
            );
    }
    
    public function logoutAction()
    {
        $this->request->deleteSessionParam('kids');
        $this->request->deleteSessionParam(self::PARENT_KEY);
        $this->redirect('/');
    }
}