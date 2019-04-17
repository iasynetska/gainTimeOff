<?php
namespace controllers;
use core\Request;
use core\LangManager;

class BaseController
{
    protected $request;
    private $lang;
    
    public function __construct(Request $request, LangManager $lang)
    {
        $this->request = $request;
        $this->lang = $lang;
    }

    protected function getLangParams()
    {
        return $this->lang->getLangParams();
    }
}