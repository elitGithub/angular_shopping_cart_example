<?php


namespace App;


use App\Helpers\JWTHelper;

class Session
{
    protected const FLASH_KEY = 'flash_messages';
    protected const TOKEN_KEY = 'token';

    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $flashMessages = $_SESSION[static::FLASH_KEY] ?? [];
        foreach ($flashMessages as $key => &$flashMessage) {
            $flashMessage['remove'] = true;
        }

        $_SESSION[static::TOKEN_KEY] = '';
        $_SESSION[static::FLASH_KEY] = $flashMessages;
    }

    public function validateSession(): bool
    {
        $headers = Application::$app->request->getHeaders();
        $request = Application::$app->request->getBody();
        if (isset($headers['Authorization'])) {
            $authToken = str_replace('Bearer ', '', $headers['Authorization']) ?? null;
        }

        if (isset($request['token'])) {
            $authToken = str_replace('Bearer ', '', $request['token']) ?? null;
        }

        if (!$authToken) {
            return false;
        }

        if (JWTHelper::validate($authToken)) {
            $payload = JWTHelper::parseToken($authToken);
            $this->set('token', $authToken);
            $this->set('userid', $payload['user_id']);
            return true;
        }
        return false;

    }

    public function setFlash($key, $message)
    {
        $_SESSION[static::FLASH_KEY][$key] = [
            'value'  => $message,
            'remove' => false,
        ];
    }

    public function setArray(array $userValues)
    {
        foreach ($userValues as $key => $value) {
            $this->set($key, $value);
        }
    }

    public function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public function get($key)
    {
        return $_SESSION[$key] ?? false;
    }

    public function remove($key)
    {
        unset($_SESSION[$key]);
    }

    public function getFlash($key)
    {
        return $_SESSION[static::FLASH_KEY][$key]['value'] ?? false;
    }

    public function __destruct()
    {
        $flashMessages = $_SESSION[static::FLASH_KEY] ?? [];
        foreach ($flashMessages as $key => &$flashMessage) {
            if ($flashMessage['remove'] === true) {
                unset($flashMessages[$key]);
            }
        }

        $_SESSION[static::FLASH_KEY] = $flashMessages;
    }

}