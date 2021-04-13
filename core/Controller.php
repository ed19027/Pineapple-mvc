<?php

namespace app\core;

abstract class Controller
{
    /**
     * Helper method for controllers to shorten the
     * syntax when turning to Router's renderView method. 
     * 
     * @return
     */
    public function view($view, $params = [])
    {
        return Application::$app->router->renderView($view, $params);
    }
}
