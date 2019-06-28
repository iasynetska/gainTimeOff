<?php
namespace controllers;
use core\dto\ErrorMessage;

class ErrorMessageController extends RestController
{    
    public function getAction()
    {
        $this->checkRequestMethod($this->request::METHOD_GET);
        $errorName = $this->request->getGetParam('errorName');
        
        $errorMessage = $this->langManager->getLangParams()[$errorName];
        if(isset($errorMessage))
        {
            $this->content = new ErrorMessage($errorMessage);
        }
        else
        {
            http_response_code(406);
            $this->content = new ErrorMessage($this->langManager->getLangParams()['lg_err_default']);
        }
    }
}