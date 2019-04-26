<?php
namespace core;

class LangManager
{
    private $request;
    private $langParams;
    private $selectedLang;
    
    public function __construct(Request $request)
    {
        $this->request = $request;
    }
    
    public function getSelectedLang() 
    {
        if(!isset($this->selectedLang))
        {
            $lang = filter_input(INPUT_GET, 'lang');
            
            if(($lang==='en' || $lang==='pl') && $this->request->getSessionParam('lang')!==$lang)
            {
                $this->request->addSessionParam('lang', $lang);
            }
            else if($this->request->getSessionParam('lang') === NULL)
            {
                $this->request->addSessionParam('lang', 'en');
            }
            
            $this->selectedLang = $this->request->getSessionParam('lang');
        }
        return $this->selectedLang;
    }
    
    public function getLangParams()
    {
        if(!isset($this->langParams))
        {
            $lang = $this->getSelectedLang();
            $this->langParams = include (dirname(__DIR__, 1)). '/languages/' . $lang . '.php';
        }
        return $this->langParams; 
    }
    
}