<?php
namespace app\core\blade\form;

use app\core\Model;

abstract class Field
{
    public Model $model;
    public string $attribute;
    
    public string $type;
    public array $rules;
    public string $invalid;
    public string $required;

    public function __construct(
        Model $model,
        string $attribute
    ) {
        $this->model = $model;
        $this->attribute = $attribute;
    }

    abstract public function setInput();

    public function __toString()
    {
        return sprintf(
            "%s\n\t<div class=\"invalid-feedback\">%s</div>\n",
            $this->setInput(),
            $this->model->getFirstError($this->attribute),
        );
    }
}