<?php

namespace app\core;

class Request
{
    //Get the path from URL 
    public function path() 
    {
        $path = $_SERVER['REQUEST_URI'] ?? '/';
        //Find the position of the '?' in a string, if there isn't returns false 
        $position = strpos($path, '?');

        if($position === false){
            return $path;
        }
        return substr($path, 0, $position);
    }
    
    public function method()
    {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }

    public function isPost()
    {
        //returns true - if method is POST
        return $this->method() === 'post';
    }

    public function input() //gets and returns input from user
    {   
        $input = [];
        if ($this->method() === 'get'){
            foreach($_GET as $key => $value){
                //filter_input() - looks in $_GET with INPUT_GET, takes $key and removes invalid chars
                $input[key] = filter_input(INPUT_GET, $kay, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }
        if ($this->method() === 'post'){
            foreach($_POST as $key => $value){
                $input[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }

        return $input; //On result - secure filtered input data 
    }

}