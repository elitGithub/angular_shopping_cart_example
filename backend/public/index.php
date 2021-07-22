<?php

use App\Helpers\AppRoutes;
use App\Models\User;
use App\Application;
use Dotenv\Dotenv;

require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

$dotenv = Dotenv::createImmutable(dirname(__DIR__));
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


$app = new Application(dirname(__DIR__), $config);
//$app->on(Application::EVENT_BEFORE_REQUEST, function () {
//	echo "before request";
//});
$app->router->registerRoutes(AppRoutes::routes());


$app->run();