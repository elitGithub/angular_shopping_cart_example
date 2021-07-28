<?php

// @TODO: I know laravel is smarter than this. Maybe do something similar using DBAL?
namespace App;


use App\DB\Database;
use PDO;

abstract class Migration
{
	public Database $db;
	public static string $migrationsDir = 'Migrations';

	public function __construct()
	{
		$this->db = Application::$app->db;
	}

	abstract public function up();

	abstract public function down();


}