<?php
namespace core;

class DynamicJSProducer
{
    const JS_COMMON = '/js/common.js';
    const JS_JQUERY = '/js/jquery-3.3.1.min.js';
    const JS_RECAPTCHA = 'https://www.google.com/recaptcha/api.js?hl=%s';
    
    static function produceJSLinks(array $jsLinks) 
    {
        $dynamicJS = '';
        foreach($jsLinks as $jsLink)
        {
            $dynamicJS .= '<script src="' . $jsLink . '"></script>';
        }
        return $dynamicJS;
    }
}