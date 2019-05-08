<?php
namespace controllers;
use core\Request;
use core\LangManager;
use core\dto\ErrorMessage;

class ErrorMessageController extends RestController
{
    private $langManager;
    
    public function __construct(Request $request, LangManager $langManager)
    {
        parent::__construct($request);
        $this->langManager = $langManager;
    }
    
    public function getAction()
    {
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