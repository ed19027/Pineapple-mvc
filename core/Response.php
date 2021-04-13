<?php

namespace app\core;

class Response
{
    /**
     * Set the response code in browser
     * 
     * @param int $code
     */
    public static function setStatusCode(int $code)   
    {
        http_response_code($code);
    }
    
    /**
     * Redirect user to the specified URL
     * 
     * @param string $url
     */
    public static function redirect($uri)
    {
        header("Location: $uri");
    }
}