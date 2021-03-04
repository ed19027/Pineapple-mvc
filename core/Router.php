<?php 
namespace app\core;

class Router
{
    public Request $request;
    protected array $routes = [];
    
    public function __construct(Request $request)
    {
        $this->request = $request;
    }
    //
    public function get($path, $callback)
    {
        $this->routes['get'][$path] = $callback;
    }

    public function post($path, $callback)
    {
        $this->routes['post'][$path] = $callback;
    }

    public function layoutContent()
    {
        ob_start(); //Turn on output buffering (nothing is outputed in browser)
        include_once Application::$ROOT_DIR."/views/layouts/main.php";
        return ob_get_clean(); //Get current buffer contents and delete current output buffer

    }
    public function viewContent($view)
    {
        ob_start();
        include_once Application::$ROOT_DIR."/views/$view.php";
        return ob_get_clean();

    }

    public function renderView($view)
    {
        $layoutContent = $this->layoutContent();
        $viewContent = $this->viewContent($view);
        return str_replace('{{content}}', $viewContent, $layoutContent);
    }

    public function resolve()
    {
        $path = $this->request->path();
        $method = $this->request->method();
        $callback = $this->routes[$method][$path] ?? false; //Assuming false, if route doesn't exist

        if ($callback === false) {
            Application::$app->response->setStatusCode(404);
            return 'Not found';
        }

        if (is_string($callback)) {
            return $this->renderView($callback);
        }

        if (is_array($callback)) {
            $callback[0] = new $callback[0]();
        }

        return call_user_func($callback, $this->request);
    }
}