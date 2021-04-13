<?php
namespace app\models;

use app\core\database\DatabaseModel as Model;

class Subscription extends Model
{
    public string $email = '';
    public string $tos = '';
    public string $domain = '';
    
    public function table(): string
    {
        return 'emails'; //rename subscriptions
    }

    public function columns(): array
    {
        return ['email', 'domain', 'created_at'];
    }

    public function rules(): array     
    {
        return [
            'email' => [
                self::REQUIRED_EMAIL,
                self::EMAIL,
                [self::TLD, 'tld' => 'co'],
                [self::UNIQUE, 'class' => self::class]
            ],
            'tos' => [self::REQUIRED_TOS]
        ];
    }

    public function save()
    {
        return parent::save();
    }
}