<?php


use App\Models\User;
use App\Application;

require_once __DIR__ . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();


$config = [
	'db'        => [
		'dsn'      => 'mysql:host=' . $_ENV['DB_HOST'] . ';port=' . $_ENV['DB_PORT'] . ';dbname=' . $_ENV['DB_NAME'],
		'user'     => $_ENV['DB_USER'],
		'password' => $_ENV['DB_PASSWORD'],
		'dbName'   => $_ENV['DB_NAME'],
	],
	'userClass' => User::class,
];


$app = new Application(__DIR__, $config);
if (isset($argv[1]) && $argv[1] === 'rollback') {
	// TODO: implement number of steps to go back. Right now will got back one batch
	$app->db->reverseMigrations();
	return;
} else {
	$app->db->applyMigrations();
}