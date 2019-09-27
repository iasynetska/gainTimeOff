<?php 
namespace controllers;

use \Exception;
use core\Exceptions\ValidatorException;
use core\TimeConverter;
use core\dto\Message;
use models\TimeFacade;

class RestTimeController extends RestController
{    
    public function saveTimePlayedAction()
    {
        $this->checkRequestMethod($this->request::METHOD_POST);
        
        $kidName = $this->request->getPostParam('kidName');
        $kid = $this->request->getSessionParam('parent')->getKids()[$kidName];
        $timePlayed = $this->request->getPostParam('timePlayed');
        $timePlayed = (-1) * abs(TimeConverter::convertStrToSeconds($timePlayed));
        $timeFacade = new TimeFacade();
        
        try
        {            
            $timeFacade->saveTimeAndChangeKidTime($kid, $timePlayed);
        }
        catch (ValidatorException $e)
        {
            $errors = $e->getErrors();
            $this->request->addSessionParam('errors', $errors);
        }
        catch (Exception $e)
        {
            $this->content = new Message($e->getMessage());
            http_response_code(500);
        }
    }
}