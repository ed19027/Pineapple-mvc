<?php
namespace app\core\blade\form;

use app\core\Model;

class Form
{
    public static function begin($action, $method, $option = '')
    {
        echo sprintf('<form action="%s" method="%s" %s>', $action, $method, $option);
        return new Form();
    }

    public static function end()
    {
        echo '</form>';
    }

    public function input(Model $model, string $attribute, $rules = [])
    {
        return new Input($model, $attribute, $rules);
    }

    public function checkbox(Model $model, string $attribute)
    {
        return new Checkbox($model, $attribute);
    }

}