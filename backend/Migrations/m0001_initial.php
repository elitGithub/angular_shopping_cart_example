<?php

namespace App\Migrations;

use eligithub\phpmvc\Application;
use eligithub\phpmvc\Migration;

class m0001_initial extends Migration {

	public function up()
	{
		$sql = "CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL,
    first_name VARCHAR(255) NOT NULL,
    last_name VARCHAR(255) NOT NULL,
    status TINYINT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP) ENGINE=INNODB";
		$this->db->pdo->exec($sql);
	}

	public function down()
	{
		$sql = 'DROP TABLE IF EXISTS users';
		$this->db->pdo->exec($sql);
	}
}