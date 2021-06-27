<?php


namespace App\Models;


use eligithub\phpmvc\Application;
use eligithub\phpmvc\Model;

class LoginForm extends Model
{

	public string $email = '';
	public string $password = '';

	public function rules(): array
	{
		return [
			'email'    => [static::RULE_REQUIRED, static::RULE_EMAIL],
			'password' => [static::RULE_REQUIRED],
		];
	}

	public function login()
	{
		$user = User::findOne(['email' => $this->email]);
		if (!$user) {
			$this->addError('email', 'User with this email address does not exist.');
			return false;
		}

		if (password_verify($this->password, $user->password)) {
			$this->addError('password', 'Password is in correct');
			return false;
		}

		return Application::$app->login($user);
	}

	public function labels(): array
	{
		return [
			'email'    => 'Your Email',
			'password' => 'Password',
		];
	}

}