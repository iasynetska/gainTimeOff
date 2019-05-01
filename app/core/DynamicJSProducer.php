<?php
namespace core;

class DynamicJSProducer
{
    const JS_COMMON = '/gaintimeoff/js/validateForms.js';
    const JS_VALIDATE_FORM = '/gaintimeoff/js/validateForms.js';
    
    static function produceJSLinks(array $jsLinks) 
    {
        $dynamicJS = '';
        foreach($jsLinks as $jsLink)
        {
            $dynamicJS .= '<script src="'  .$jsLink . '"></script>';
        }
        return $dynamicJS;
    }
}