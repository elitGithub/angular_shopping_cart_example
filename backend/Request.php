<?php


namespace App;


use App\Helpers\URL;

class Request
{

    private URL $url;

    public function __construct()
    {
        $this->url = new URL();
    }

    public function getPath()
    {
        $path = $_SERVER['REQUEST_URI'] ?? '/';
        return $this->url->segment($path);
    }

    public function method(): string
    {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }

    public function isGet(): bool
    {
        return ($this->method() === 'get');
    }

    public function isPost(): bool
    {
        return ($this->method() === 'post');
    }

    public function getBody(): array
    {
        $body = [];

        if ($this->isGet()) {
            foreach ($_GET as $key => $value) {
                $body[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }

        if ($this->isPost()) {
            if (empty($_POST)) {
                // If a form submits content-type of application/json, $_POST and $_REQUEST are not automatically filled.
                $_POST = array_merge($_POST, json_decode(file_get_contents('php://input'), true));
                $_REQUEST = array_merge($_POST, $_REQUEST);
                foreach ($_POST as $key => $value) {
                    $body[$key] = filter_var($value, FILTER_SANITIZE_SPECIAL_CHARS);
                }
            } else {
                foreach ($_POST as $key => $value) {
                    $body[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
                }
            }
        }
        return $body;
    }

    public function getHeaders(): ?string
    {
        $headers = null;
        if (isset($_SERVER['Authorization'])) {
            $headers = trim($_SERVER["Authorization"]);
        } elseif (isset($_SERVER['HTTP_AUTHORIZATION'])) {
            //Nginx or fast CGI
            $headers = trim($_SERVER["HTTP_AUTHORIZATION"]);
        } elseif (function_exists('apache_request_headers')) {
            $requestHeaders = apache_request_headers();
            // Server-side fix for bug in old Android versions (a nice side-effect of this fix means we don't care about capitalization for Authorization)
            $requestHeaders = array_combine(array_map('ucwords', array_keys($requestHeaders)),
                array_values($requestHeaders));
            //print_r($requestHeaders);
            if (isset($requestHeaders['Authorization'])) {
                $headers = trim($requestHeaders['Authorization']);
            }
        }
        return $headers;
    }
}