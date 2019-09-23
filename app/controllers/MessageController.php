<?php
namespace controllers;

use core\dto\Message;

class MessageController extends RestController
{    
    public function getAction()
    {
        $this->checkRequestMethod($this->request::METHOD_GET);
        $messageName = $this->request->getGetParam('messageName');
        
        $message = $this->langManager->getLangParams()[$messageName];
        if(isset($message))
        {
            $this->content = new Message($message);
        }
        else
        {
            http_response_code(406);
            $this->content = new Message($this->langManager->getLangParams()['lg_err_default']);
        }
    }
}