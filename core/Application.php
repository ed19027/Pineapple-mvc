<?php
namespace app\core;

use app\core\database\Database;

class Application
{
    public Request $request;
    public Response $response;
    public Router $router;
    public Database $db;
    public static Application $app;
    public static string $ROOT_DIR;

    /**
     * Create a new application instance - instanceating 
     * core classes and application itself.
     * 
     * self::$app = $this - aproach to use core classes 
     * and their methods throughout the application.
     */
    public function __construct($config) 
    {
        $this->request = new Request();
        $this->response = new Response();
        $this->router = new Router($this->request);
        $this->db = new Database($config['db']);
        self::$app = $this; 
        self::$ROOT_DIR = $config['app']['dir'];
    }
    
    /**
     * Display prepared output to the user
     */
    public function run()
    {
        echo $this->router->resolve();
    }

}
