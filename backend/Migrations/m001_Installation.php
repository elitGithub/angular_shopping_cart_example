<?php

namespace App\Migrations;

use App\Migration;

class m001_Installation extends Migration {

	public const STATEMENTS = [
		'users' => "CREATE TABLE IF NOT EXISTS users (
          id INT AUTO_INCREMENT PRIMARY KEY,
          username VARCHAR(255) NOT NULL,
          email VARCHAR(255) NOT NULL,
          first_name VARCHAR(255) NOT NULL,
          last_name VARCHAR(255) NOT NULL,       
          status VARCHAR(255) NOT NULL DEFAULT 'active',
          role_id INT(11) NOT NULL DEFAULT 0,
          deleted TINYINT NOT NULL DEFAULT 0,
          created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP) ENGINE=INNODB",
		'products' => "CREATE TABLE IF NOT EXISTS products (
          id INT AUTO_INCREMENT PRIMARY KEY,
          name VARCHAR(255) NOT NULL,
          description LONGTEXT NOT NULL,
          price FLOAT(5,2) NOT NULL,
          category_id INT NOT NULL DEFAULT 1,
          in_stock TINYINT NOT NULL DEFAULT 1,
          deleted TINYINT NOT NULL DEFAULT 0,
          created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP) ENGINE=INNODB",
		'categories' => "CREATE TABLE IF NOT EXISTS categories (
          id INT AUTO_INCREMENT PRIMARY KEY,
          name VARCHAR(255) NOT NULL,
          description LONGTEXT NOT NULL,
          deleted TINYINT NOT NULL DEFAULT 0,
          created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP) ENGINE=INNODB",
		'clients' => "CREATE TABLE IF NOT EXISTS clients (
          id INT AUTO_INCREMENT PRIMARY KEY,
          email VARCHAR(255) NOT NULL,
          first_name VARCHAR(255) NOT NULL,
          last_name VARCHAR(255) NOT NULL,
          phone INT(11) NOT NULL,
          deleted TINYINT NOT NULL DEFAULT 0,
          created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP) ENGINE=INNODB",
		'orders' => "CREATE TABLE IF NOT EXISTS orders (
          id INT AUTO_INCREMENT PRIMARY KEY,
          client_id INT(11) NOT NULL,
          total INT(11) NOT NULL,
          completed TINYINT NOT NULL,
          created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP) ENGINE=INNODB",
		'carts' => "CREATE TABLE IF NOT EXISTS carts (
          client_id INT(11) PRIMARY KEY,
          product_id INT(11) NOT NULL,
          quantity INT(11) NOT NULL DEFAULT 1,
          order_id INT(11) NOT NULL,
          created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP) ENGINE=INNODB",
        'roles' => "CREATE TABLE IF NOT EXISTS roles (
          id INT(11) PRIMARY KEY,
          name VARCHAR(255) NOT NULL,
          deleted TINYINT NOT NULL DEFAULT 0,
          created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP) ENGINE=INNODB",
	];

	public function up()
	{
		foreach (static::STATEMENTS as $sql) {
			$stmt = $this->db->prepare($sql);
			$stmt->execute();
		}
	}

	public function down()
	{
		$tables = array_keys(static::STATEMENTS);
		foreach ($tables as $table) {
			$sql = 'DROP TABLE IF EXISTS ?';
			$stmt = $this->db->prepare($sql);
			$stmt->bindParam(1, $table);
			$stmt->execute();
		}
	}
}