<?php

namespace app\Models;

use app\core\Model;

class Subscription extends Model
{
    public string $email;
    public bool $tos;
    
    public function subscribe()
    {
        echo 'creating new user';
    }

    public function rules(): array     
    {
        //  'property of this class' => [self:RULE]
        return [
            'email' => [self::REQUIRED, self::EMAIL, self::UNIQUE, self::DOMAIN],
            'tos' => [self::TOS]
        ];
    }
}