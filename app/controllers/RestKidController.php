<?php
namespace controllers;

use core\Exceptions\ValidatorException;
use models\KidFacade;

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
        catch (ValidatorException $e)
        {
            
        }
    }
}