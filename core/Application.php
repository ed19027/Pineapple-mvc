<?php

namespace app\core;

class Application
{
    public static string $ROOT_DIR;
    public Request $request;
    public Router $router;
    public Response $response;
    public static Application $app; //..aproach to use App::$app-> in core clases

    public function __construct($rootPath) 
    {
        self::$ROOT_DIR = $rootPath;
        self::$app = $this; //..aproach to use App::$app-> in core clases
        $this->request = new Request();
        $this->response = new Response();
        $this->router = new Router($this->request);
    }
    
    public function run()
    {
        echo $this->router->resolve();
    }

}
