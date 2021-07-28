<?php

use App\Helpers\AppRoutes;
use App\Helpers\ResponseCodes;
use App\Models\User;
use App\Application;
use Dotenv\Dotenv;
header("Access-Control-Allow-Origin: http://localhost:4200");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
if (strtolower($_SERVER['REQUEST_METHOD']) === 'options') {
    http_response_code(ResponseCodes::HTTP_OK);
    header('HTTP/1.1 200 OK');
    die('0');
}

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