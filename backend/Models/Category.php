<?php


namespace App\Models;


use App\DB\DbModel;

class Category extends DbModel
{

    public static function tableName(): string
    {
        return 'categories';
    }

    public function attributes(): array
    {
        return ['id', 'title'];
    }

    public static function primaryKey(): string
    {
        return 'id';
    }

    public function rules(): array
    {
        return [];
    }
}