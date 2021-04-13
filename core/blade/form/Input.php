<?php
namespace app\core\blade\form;

use app\core\Model;

class Input extends Field
{
    const TEXT = 'text';
    const EMAIL = 'email';
    const REQUIRED = 'required';

    public function __construct(
        Model $model,
        string $attribute,
        array $rules
    ) {
        $this->rules = $rules;
        $this->type = self::TEXT;
        $this->invalid = $model->hasError($attribute) ? ' is-invalid' : '';
        parent::__construct($model, $attribute);
    }

    public function setInput()
    {
        $rules = [];

        foreach ($this->rules as $key => $value) {
            $rules[] = "$key=\"$value\"";
        }
        return sprintf(
            '<input value="%s" name="%s" class="%s" type="%s" %s %s>',
            $this->model->{$this->attribute},
            $this->attribute,
            $this->invalid,
            $this->type,
            $this->required,
            implode(" ", $rules)
        );
    }

    public function email()
    {
        $this->type = self::EMAIL;
        return $this;
    }

    public function required()
    {
        $this->required = self::REQUIRED;
        return $this;
    }
}