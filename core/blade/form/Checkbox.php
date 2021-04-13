<?php
namespace app\core\blade\form;

use app\core\Model;

class Checkbox
{
    const REQUIRED = 'required';

    public Model $model;
    public string $attribute;
    public string $required;
    public string $invalid;
    public string $invalid_feedback;
    public string $message = 'I agree to';


    public function __construct(Model $model, string $attribute)
    {
        $this->model = $model;
        $this->attribute = $attribute;
        $this->required = '';
        $this->invalid = $model->hasError($attribute) ? 'is-invalid' : '';
        $this->invalid_feedback = $model->hasError($attribute) ? 'invalid-feedback' : '';
    }

    public function __toString()
    {
        if($this->model->hasError($this->attribute)) {
            $this->message = $this->model->getFirstError($this->attribute);
        }
        return sprintf(
            '<input class="%s" type="checkbox" name="%s" value="%s" %s>
            <label class="%s">
              <span>%s </span>
              <a href="#" class="link">terms of service</a>
            </label>',
            $this->invalid,
            $this->attribute,
            $this->model->{$this->attribute},
            $this->required,
            $this->invalid_feedback,
            $this->message
        );
    }

    public function required()
    {
        $this->required = self::REQUIRED;
        return $this;
    }
}