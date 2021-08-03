<?php

namespace App\Models;

use App\DB\DbModel;

class Order extends DbModel
{

    public static function tableName(): string
    {
        return 'orders';
    }

    public function attributes(): array
    {
        return ['id', 'client_id', 'total', 'completed', 'created_at'];
    }

    public function fillable(): array
    {
        return ['client_id', 'total', 'completed'];
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