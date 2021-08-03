<?php

namespace App\Models;

use App\DB\DbModel;
use Exception;

class Client extends DbModel
{

    public static function tableName(): string
    {
        return 'clients';
    }

    public function save(): bool
    {
        throw new Exception('Error - clients cannot be modified from here');
    }

    public function attributes(): array
    {
        return ['id', 'email', 'first_name', 'last_name', 'phone', 'deleted', 'created_at'];
    }

    public function fillable(): array
    {
        return ['email', 'first_name', 'last_name', 'phone', 'deleted'];
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