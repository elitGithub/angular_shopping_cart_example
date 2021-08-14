<?php


namespace App\Models;


use App\Application;
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
            'id',
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
        $sql = "SELECT * FROM " . static::tableName() . " WHERE " . static::primaryKey() . " = (SELECT role_id FROM " . User::tableName() . " WHERE " . User::primaryKey() . " = ?)";
        $res = Application::$app->db->preparedQuery($sql, $userid);
        return $res->fetchObject(static::class);
    }

    public function rules(): array
    {
        return [
            'name'    => [
                static::RULE_REQUIRED,
                [static::RULE_UNIQUE, 'class' => static::class],
            ],
            'id' => [
                static::RULE_REQUIRED,
                [static::RULE_UNIQUE, 'class' => static::class],
            ],
        ];
    }

    public function fillable(): array
    {
        return [
            'id',
            'name',
            'deleted',
        ];
    }
}