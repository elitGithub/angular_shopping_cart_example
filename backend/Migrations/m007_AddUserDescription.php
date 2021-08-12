<?php


namespace App\Migrations;


use App\Migration;

class m007_AddUserDescription extends Migration
{

    public function up()
    {
        $sql = "ALTER TABLE users ADD COLUMN description VARCHAR(255) AFTER user_image";
        $this->db->preparedQuery($sql);
    }

    public function down()
    {
        // Installation removes the table
    }
}