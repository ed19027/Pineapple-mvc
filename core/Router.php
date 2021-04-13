<?php 
namespace app\core;

class Router
{
    public Request $request;

    /**
     * Asociative array of application routes.
     */
    protected array $routes = [];
    
    /**
     * Create a new request instance.
     *
     * @param app\core\Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Asign 'GET' routes to asociative array - the url path 
     * as key, specified controller and its method as a value.
     *
     * @param  string $path
     * @param  array  $callback [SomeController::class, 'method']
     */
    public function get($path, $callback)
    {
        $this->routes['get'][$path] = $callback;
    }

    /**
     * Asign 'POST' routes to asociative array - the url path 
     * as key, specified controller and its method as a value. 
     *
     * @param  string $path
     * @param  array  $callback [SomeController::class, 'method']
     */
    public function post($path, $callback)
    {
        $this->routes['post'][$path] = $callback;
    }

    /**
     * Determines the current path and method. Based on defined
     * routes take corresponding callback, execute it and output
     * the result to the user.
     * 
     * If callback is:
     *   • false - returns 'Not Found' fith status code 404.
     *   • string - returns view bypassing the controller.
     *   • array - creates an instance of controller and returns executed method.
     *
     * @return mixed
     */
    public function resolve()
    {
        $path = $this->request->path();
        $method = $this->request->method();
        $callback = $this->routes[$method][$path] ?? false;

        if ($callback === false) {
            Response::setStatusCode(404);
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

    /**
     * Build up whole view from layout and subview.
     *
     * @param  string  $view
     * @param  array  $params
     * @return string
     */
    public function renderView($view, $params = [])
    {
        $layoutContent = $this->layoutContent();
        $viewContent = $this->viewContent($view, $params);
        return str_replace('{{content}}', $viewContent, $layoutContent);
    }

    /**
     * Inlude layout content in output buffer, get content from 
     * it and delete buffer.
     *  
     * Output buffer ensures that nothing is outputed in browser.
     *
     * @return string|false
     */
    public function layoutContent()
    {
        ob_start();
        include_once Application::$ROOT_DIR.'/views/layouts/main.php';
        return ob_get_clean();
    }

    /**
     * Inlude subview content with passed parameters in output 
     * buffer, get content from it and delete buffer.
     *
     * $$key - evaluates as a variable to be used in the view.
     * Output buffer ensures that nothing is outputed in browser.
     * 
     * @param  string $view
     * @param  array $params
     * @return string|false
     */
    public function viewContent($view, $params)
    {
        foreach ($params as $key => $value) {
            $$key = $value;
        }
        ob_start();
        include_once Application::$ROOT_DIR."/views/$view.php";
        return ob_get_clean();
    }
}