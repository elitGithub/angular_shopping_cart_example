<?php


namespace App;

use JetBrains\PhpStorm\NoReturn;
use Stringable;

/**
 * Class Response
 * @package eligithub\phpmvc
 */
class Response implements Stringable
{
    public bool $success = false;
    public string $message = '';
    public array $data = [];

    /**
     * @param  array  $data
     *
     * @return Response
     */
    public function setData(array $data): Response
    {
        $this->data = $data;
        return $this;
    }

    /**
     * @param  string  $message
     *
     * @return Response
     */
    public function setMessage(string $message): Response
    {
        $this->message = $message;
        return $this;
    }

    /**
     * @param  bool  $success
     *
     * @return Response
     */
    public function setSuccess(bool $success): Response
    {
        $this->success = $success;
        return $this;
    }


    public function setStatusCode(int $code)
    {
        http_response_code($code);
    }

    public function redirect(string $location)
    {
        header("Location:$location");
    }

    #[NoReturn] public function sendResponse()
    {
        die((string)$this);
    }

    public function __toString(): string
    {
        return json_encode([
            'success' => $this->success,
            'message' => $this->message,
            'data'    => $this->data,
        ]);
    }
}