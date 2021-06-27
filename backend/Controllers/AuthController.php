<?php


namespace App\Controllers;

use eligithub\phpmvc\Application;
use eligithub\phpmvc\Controller;
use eligithub\phpmvc\Middlewares\AuthMiddleware;
use eligithub\phpmvc\Request;
use eligithub\phpmvc\Response;
use App\Models\LoginForm;
use App\Models\User;

/**
 * Class AuthController
 * @package App\controllers
 */
class AuthController extends Controller
{

	public function __construct()
	{
		$this->registerMiddleware(new AuthMiddleware(['profile']));
	}

	public function login(Request $request, Response $response): bool|array|string
	{
		$loginForm = new LoginForm();
		if ($request->isPost()) {
			$loginForm->loadData($request->getBody());
			if ($loginForm->validate() && $loginForm->login()) {
				$response->redirect('/');
				return true;
			}
		}
		$this->setLayout('auth');
		return $this->render('login', [
			'model' => $loginForm,
		]);
	}

	/**
	 * @param  Request  $request
	 *
	 * @return bool|array|string
	 */
	public function register(Request $request): bool|array|string
	{
		$this->setLayout('auth');
		$user = new User();
		if ($request->isPost()) {
			$user->loadData($request->getBody());
			if ($user->validate() && $user->save()) {
				Application::$app->session->setFlash('success', 'Thanks for registering');
				Application::$app->response->redirect('/');
			}
			return $this->render('register', [
				'model' => $user,
			]);
		}
		return $this->render('register', [
			'model' => $user,
		]);
	}

	public function logout(Request $request, Response $response) {
		Application::$app->logout();
		$response->redirect('/');
	}

	public function profile(): bool|array|string
	{
		return $this->render('profile');
	}



}