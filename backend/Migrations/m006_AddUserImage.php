<?php


namespace App\Migrations;


use App\Migration;

class m006_AddUserImage extends Migration
{

    public function up()
    {
        $sql = "ALTER TABLE users ADD COLUMN user_image VARCHAR(255) AFTER last_name";
        $this->db->preparedQuery($sql);
    }

    public function down()
    {
        // Installation removes the table
    }
}