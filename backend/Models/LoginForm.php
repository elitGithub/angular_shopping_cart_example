<?php


namespace App\Models;


use App\Application;
use App\Interfaces\Guard;
use App\Model;

class LoginForm extends Model implements Guard
{

    public string $username = '';
    public string $password = '';
    public ?User $user;

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
        $this->user = User::findOne(['username' => $this->username]);
        if (!$this->user) {
            $this->addError('username', 'User with this username does not exist.');
            return false;
        }

        if (!password_verify($this->password, $this->user->password)) {
            $this->addError('password', 'Password is incorrect');
            return false;
        }

        $this->user->token = User::generateJwt($this->user->{$this->user->primaryKey()});

        return Application::$app->login($this->user);
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