<?php

// @TODO: I know laravel is smarter than this. Maybe do something similar using DBAL?
namespace App;


use App\DB\Migrator;

abstract class Migration
{
	public Migrator $db;
	public static string $migrationsDir = 'Migrations';

	public function __construct()
	{
		$this->db = Application::$app->migrator;
	}

	abstract public function up();

	abstract public function down();


}