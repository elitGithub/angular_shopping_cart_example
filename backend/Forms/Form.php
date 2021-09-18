<?php


namespace App\Forms;


use App\Model;
use JetBrains\PhpStorm\Pure;

class Form
{
    private static array $forms = [
        'login'         => 'AuthForm',
        'createProduct' => 'ProductForm',
    ];

    public static function hasForm ($path)
    {
        return static::$forms[$path] ?? false;
    }

    public static function begin (string $action, string $method): Form
    {
        echo sprintf('<form action="%s" method="%s">', $action, $method);
        return new Form();
    }

    public static function end ()
    {
        echo '</form>';
    }

    public function field (Model $model, $attribute): InputField
    {
        return new InputField($model, $attribute);
    }
}