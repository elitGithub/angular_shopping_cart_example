<?php


namespace App\Models;


use App\Application;
use App\Interfaces\Guard;
use App\Model;

class LoginForm extends Model implements Guard
{

    public string $username = '';
    public string $password = '';

    public function rules(): array
    {
        return [
            'username' => [static::RULE_REQUIRED],
            'password' => [static::RULE_REQUIRED],
        ];
    }

    public function loadData(array $data)
    {
        $this->removeUnexpectedFields($data);
        foreach ($data as $key => $value) {
            $this->{$key} = $value;
        }
    }

    public function login()
    {
        /**
         * @var User
         */
        $user = User::findOne(['username' => $this->username]);
        if (!$user) {
            $this->addError('username', 'User with this username address does not exist.');
            return false;
        }

        if (password_verify($this->password, $user->password)) {
            $this->addError('password', 'Password is in correct');
            return false;
        }

        $user->token = $user->generateJwt($user->{$user->primaryKey()});

        return Application::$app->login($user);
    }

    public function labels(): array
    {
        return [
            'username' => 'Username',
            'password' => 'Password',
        ];
    }

    public function expectedFields(): array
    {
        return [
            'username',
            'password',
        ];
    }

    public function removeUnexpectedFields(&$input): void
    {
        $inputFields = array_keys($input);
        foreach ($inputFields as $inputKey) {
            if (!in_array($inputKey, $this->expectedFields())) {
                unset($input[$inputKey]);
            }
        }
    }
}