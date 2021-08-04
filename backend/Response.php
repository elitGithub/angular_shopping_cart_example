<?php


namespace App;

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


    public function setStatusCode(int $code): void
    {
        http_response_code($code);
    }

    public function redirect(string $location): void
    {
        header("Location:$location");
    }

    public function sendResponse(): void
    {
        die((string)$this);
    }

    public function __toString(): string
    {
        // @Improvement: could probably add more stuff here.
        return json_encode([
            'success' => $this->success,
            'message' => $this->message,
            'data'    => $this->data,
        ]);
    }
}