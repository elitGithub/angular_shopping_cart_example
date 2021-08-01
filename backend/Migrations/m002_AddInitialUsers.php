<?php


namespace App\Migrations;


use App\Migration;
use App\Model;
use App\Models\User;

class m002_AddInitialUsers extends Migration
{
    // return ['first_name', 'last_name', 'email', 'password', 'status', 'deleted'];
    public const USERS_TO_ADD = [
        [
            'username'         => 'admin',
            'first_name'       => 'Shop',
            'last_name'        => 'Admin',
            'email'            => 'admin@shop.com',
            'password'         => 'nncRdXQyfDC3Pg74ZEXL6TCU',
            'confirm_password' => 'nncRdXQyfDC3Pg74ZEXL6TCU',
            'status'           => User::STATUS_ACTIVE,
            'deleted'          => Model::NOT_DELETED,
            'role_id'          => 'R1',
        ],
        [
            'username'         => 'manager',
            'first_name'       => 'Shop',
            'last_name'        => 'Manager',
            'email'            => 'manager@shop.com',
            'password'         => 'bQGhQtcCHuvwcqUahegHshXZ',
            'confirm_password' => 'bQGhQtcCHuvwcqUahegHshXZ',
            'status'           => User::STATUS_ACTIVE,
            'deleted'          => Model::NOT_DELETED,
            'role_id'          => 'R2',
        ],
    ];

    public function up()
    {
        foreach (static::USERS_TO_ADD as $data) {
            $user = new User();
            $user->loadData($data);
            if ($user->validate() && $user->save()) {
                echo "User " . $user->username . " created successfully" . PHP_EOL;
            } else {
                print_r($user->errors);
                echo "User " . $user->username . " WAS NOT CREATED" . PHP_EOL;
            }
        }
    }

    public function down()
    {
        foreach (static::USERS_TO_ADD as $data) {
            $user = new User();
            $user->loadData($data);
            $user->findByUserName();
            $user->delete($user->id);
        }
    }
}