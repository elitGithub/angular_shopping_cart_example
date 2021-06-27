<?php


namespace App\Migrations;


use eligithub\phpmvc\Migration;

class m0003_add_password_column_to_users_table extends Migration
{

	public function up()
	{
		$sql = 'ALTER TABLE users ADD COLUMN password VARCHAR(512) NOT NULL AFTER email';
		$this->db->pdo->exec($sql);
	}

	public function down()
	{
		$sql = 'ALTER TABLE users DROP COLUMN IF EXISTS password';
		$this->db->pdo->exec($sql);
	}
}