<?php


use App\Models\User;
use eligithub\phpmvc\Application;

require_once __DIR__ . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();


$config = [
	'db'        => [
		'dsn'      => $_ENV['DB_DSN'],
		'user'     => $_ENV['DB_USER'],
		'password' => $_ENV['DB_PASSWORD'],
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