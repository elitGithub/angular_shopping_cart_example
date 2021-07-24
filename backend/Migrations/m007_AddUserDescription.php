<?php


namespace App\Migrations;


use App\Migration;

class m007_AddUserDescription extends Migration
{

    public function up()
    {
        $sql = "ALTER TABLE users ADD COLUMN description VARCHAR(255) AFTER user_image";
        $this->db->pdo->exec($sql);
    }

    public function down()
    {
        $sql = 'ALTER TABLE users DROP COLUMN IF EXISTS description';
        $this->db->pdo->exec($sql);
    }
}