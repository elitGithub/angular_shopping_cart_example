<?php


namespace App\Migrations;


use App\Migration;

class m006_AddUserImage extends Migration
{

    public function up()
    {
        $sql = "ALTER TABLE users ADD COLUMN user_image VARCHAR(255) AFTER last_name";
        $this->db->pdo->exec($sql);
    }

    public function down()
    {
        $sql = 'ALTER TABLE users DROP COLUMN IF EXISTS user_image';
        $this->db->pdo->exec($sql);
    }
}