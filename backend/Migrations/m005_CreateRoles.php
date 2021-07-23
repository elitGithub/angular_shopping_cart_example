<?php


namespace App\Migrations;


use App\Migration;
use App\Models\Role;

class m005_CreateRoles extends Migration
{
    const ROLES = [
        [
            'id'      => 'R1',
            'name'    => 'Administrator',
            'deleted' => 0,
        ],
        [
            'id'      => 'R2',
            'name'    => 'Manager',
            'deleted' => 0,
        ],
    ];

    public function up()
    {
        foreach (static::ROLES as $item) {
            $role = new Role();
            $role->loadData($item);
            if ($role->validate() && $role->save()) {
                echo "Role {$item['name']} created successfully" . PHP_EOL;
            } else {
                print_r($role->errors);
                echo "Role {$item['name']} WAS NOT created" . PHP_EOL;
            }
        }
    }

    public function down()
    {
        // TODO: Implement down() method.
    }
}