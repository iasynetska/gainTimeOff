<?php
namespace controllers;

use \Exception;
use models\KidFacade;
use core\dto\Message;

class RestKidController extends  RestController
{
    public function doDeletingKidAction()
    {
        $this->checkRequestMethod($this->request::METHOD_POST);
        
        $kidName = $this->request->getPostParam('kidName');
        $kid = $this->request->getSessionParam('parent')->getKids()[$kidName];
        $kidFacade = new KidFacade($this->request);
        
        try
        {
            $kidFacade->deleteKidAndRelativeItems($kid);
        }
        catch (Exception $e)
        {
            $this->content = new Message($e->getMessage());
            http_response_code(500);
        }
    }
}