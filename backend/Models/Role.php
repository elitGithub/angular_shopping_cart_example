<?php


namespace App\Models;


use App\DB\DbModel;

class Role extends DbModel
{

    public string $name = '';

    public static function tableName(): string
    {
        return 'roles';
    }

    public function attributes(): array
    {
        return [
            'name',
            'deleted',
        ];
    }

    public static function primaryKey(): string
    {
        return 'id';
    }

    public static function findByUser($userid)
    {
        $sql = "SELECT name FROM " . static::tableName() . " WHERE " . static::primaryKey() . " = SELECT role_id FROM " . User::tableName() . " WHERE " . User::primaryKey() . " = ?";
        $stmt = static::prepare($sql);
        $stmt->bindParam(1, $userid);
        $stmt->execute();
        return $stmt->fetchObject(static::class);
    }

    public function rules(): array
    {
        return [
            'name' => [
                static::RULE_REQUIRED,
                [static::RULE_UNIQUE, 'class' => static::class],
            ],
        ];
    }

    public function fillable(): array
    {
        return [
            'name',

        ];
    }
}