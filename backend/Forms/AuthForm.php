<?php


namespace App\Forms;


class AuthForm extends Form
{
    public static function formFields() {
        return [
            [
                'name' => 'username',
                'type' => 'text',
                'required' => true,
            ],
            [
                'name' => 'password',
                'type' => 'password',
                'required' => true,
            ],
        ];
    }
}