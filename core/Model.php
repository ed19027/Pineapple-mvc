<?php
namespace app\core;

use app\core\database\Database;
use app\core\tld\TopLevelDomain as TLD;

abstract class Model //abstract - avoids creating instance of that class
{
    /**
     * @var string Constants which defines posible rule names
     */
    public const REQUIRED_EMAIL = 'email required';
    public const REQUIRED_TOS = 'tos required';
    public const UNIQUE = 'unique';
    public const EMAIL = 'email';
    public const TLD = 'tld';


    /**
     * Associative array of atributes and their invoked error messages.
     * 
     * @var array
     */
    public array $errors = [];

    /**
     * Method for implementation in the app\models.
     * 
     * @return array Asociative array of atributes and rules which must be validated.
     */
    abstract public function rules(): array;

    /**
     * Take data from the Request and asigning to the properties of the app\models.
     *
     * @param  array $data
     */
    public function load($data)
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->{$key} = $value;
            }
        }
    }

    /**
     * Take specified rules from the app\models and perform model validation.
     *
     * @return bool
     */
    public function validate()
    {
        foreach ($this->rules() as $attribute => $rules) {
            $value = $this->{$attribute};
            foreach ($rules as $rule) {
                $ruleName = $rule;
                if (is_array($ruleName)) {
                    $ruleName = $rule[0];
                }
                if (
                    $ruleName === self::REQUIRED_EMAIL && !$value) {
                    $this->addError($attribute, self::REQUIRED_EMAIL);
                }
                if ($ruleName === self::REQUIRED_TOS && !$value) {
                    $this->addError($attribute, self::REQUIRED_TOS);
                }
                if ($ruleName === self::EMAIL && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $this->addError($attribute, self::EMAIL);
                }
                if ($ruleName === self::TLD) {
                    $tld = preg_replace(
                        '/(\S+)@(\S+)\.(\S+)/', 
                        '${3}', 
                        $value
                    );
                    if($tld === $rule['tld']) {
                        $this->addError(
                            $attribute,
                            self::TLD,
                            ['tld' => TLD::transcript()[$tld]]
                        );
                    }
                }
                if ($ruleName === self::UNIQUE) {
                    $class = $rule['class'];
                    $table = $class::table();
                    $statement = Database::prepare(
                        "SELECT * FROM $table WHERE $attribute = :attr"
                    );
                    $statement->bindValue(':attr', $value);
                    $statement->execute();
                    $record = $statement->fetchObject();
                    if ($record) {
                        $this->addError(
                            $attribute, 
                            self::UNIQUE, [
                                'table' => rtrim($table, 's'), 
                                'field' => $attribute
                            ]
                        );
                    }
                }
            }
        }
        return empty($this->errors);
    }


    /**
     * Add attributes that failed validation to errors array
     * with failad rules error message.
     * 
     * Replace placeholders in error messages with rule value.
     * 
     * @param string $attribute
     * @param string $rule
     * @param array $params
     */
    public function addError(string $attribute, string $rule, $params = [])
    {
        $message = $this->errorMessages()[$rule] ?? '';
        foreach ($params as $key => $value) { 
            $message = str_replace("{{$key}}", $value, $message);
        }
        $this->errors[$attribute][] = $message;
    }

    /**
     * Returns array of error messages.
     * 
     * @return array
     */
    public function errorMessages()
    {
        return [
            self::REQUIRED_EMAIL => 'Email address is required',
            self::REQUIRED_TOS => 'You must accept the',
            self::EMAIL => 'Please provide a valid e-mail address',
            self::TLD => 'We are not accepting subscriptions from {tld} emails',
            self::UNIQUE => 'There is already {table} with that {field}'
        ];
    }

    /**
     * Helper method for the app\core\blade\form to 
     * determine if models attribute has invoked error.
     * 
     * @return bool
     */
    public function hasError($attribute)
    {
        return $this->errors[$attribute] ?? false;
    }

    /**
     * Helper method for the app\core\blade\form to 
     * get first error of an attribute, if it exists.
     * 
     * @return bool
     */
    public function getFirstError($attribute)
    {
        return $this->errors[$attribute][0] ?? false;
    }
}