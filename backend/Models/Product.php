<?php


namespace App\Models;


use App\DB\DbModel;

class Product extends DbModel
{
    private static array $categories = [];

    // TODO: offset needs to accept pagination!
    public static function findAll($offset = 0): array
    {
        $list = parent::findAll($offset);
        if (empty(static::$categories)) {
            foreach (Category::findAll() as $category) {
                static::$categories[$category['id']] = $category['name'];
            }
        }
        return array_map(function ($item) {
            $item['category'] = static::$categories[$item['category_id']];
            return $item;
        }, $list);
    }

    public function rules(): array
    {
        return [];
    }

    public static function tableName(): string
    {
        return 'products';
    }

    public function attributes(): array
    {
        return ['id', 'name', 'description', 'price', 'category_id', 'in_stock', 'created_at'];
    }

    public static function primaryKey(): string
    {
        return 'id';
    }

    public function fillable(): array
    {
        return ['name', 'description', 'price', 'category_id', 'in_stock'];
    }

}