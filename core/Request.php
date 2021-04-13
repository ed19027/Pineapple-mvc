<?php

namespace app\core;

class Request
{
    /**
     * Get the URI, cutting of '?' and everything after it
     * 
     * @return string
     */
    public function path() 
    {
        $path = $_SERVER['REQUEST_URI'] ?? '/';
        $position = strpos($path, '?');
        if($position === false){
            return $path;
        }
        return substr($path, 0, $position);
    }
    
    /**
     * Get the name of the method
     * 
     * @return string
     */
    public function method()
    {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }

    /**
     * Get the input data from user and filter out invalid chars 
     * for every $key by looking in $_GET with INPUT_GET.
     * 
     * @param array $data 
     * @return array
     */
    public function body($data = [])
    {   
        if ($this->method() === 'get') {
            foreach($_GET as $key => $value) {
                $data[$key] = filter_input(INPUT_GET, $kay, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }
        if ($this->method() === 'post') {
            foreach($_POST as $key => $value) {
                $data[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }
        return $data;
    }

    /**
     * Helper method for controllers to determine method type
     * 
     * @return bool
     */
    public function isPost()
    {
        return $this->method() === 'post';
    }
}