<?php

namespace app\core;

abstract class Model //abstract - avoid creating instance of that class
{
    public const REQUIRED = 'required';
    public const UNIQUE = 'unique';
    public const DOMAIN = 'domain';
    public const EMAIL = 'email';
    public const TOS = 'tos';

    public array $errors = [];

    public function load($data)
    {
        foreach ($data as $key => $value) { //taking data and asigning to the properties of the model 
            if (property_exists($this, $key)) {
                $this->{$key} = $value;
            }
        }
    }

    abstract public function rules(): array;

    public function validate()
    {
        foreach ($this->rules() as $attribute => $rules) {
            $value = $this->{$attribute}; //for example - $attribute = '$email'
            foreach ($rules as $rule) {
                //rule can be string or an array
                $ruleName = $rule;
                if(!is_string($ruleName)) { 
                    $ruleName = $rule[0];
                }
                if($ruleName === self::REQUIRED && !$value) {
                    $this->addError($attribute, self::REQUIRED);
                }
                if($ruleName === self::TOS && !$value) {
                    $this->addError($attribute, self::TOS);
                }
            }
        }
        return empty($this->errors);
    }

    public function addError($attribute, $rule)
    {
        //message for the given $rule, if it exists
        $message = $this->errorMessages()[$rule] ?? '';
        $this->errors[$attribute][] = $message;
    }

    public function errorMessages()
    {
        return [
            self::REQUIRED => 'This field is required',
            self::UNIQUE => 'There is already subscription on that email',
            self::DOMAIN => 'We are not accepting subscriptions from {domain} e-mails',
            self::EMAIL => 'Please provide a valid e-mail address',
            self::TOS => 'You must accept the terms and conditions'
        ];
    }
}
