<?php


namespace App;

use App\Interfaces\JsonResponse;
use Exception;

/**
 * Class Response
 * @package eligithub\phpmvc
 */
class Response implements JsonResponse
{

    public bool $success = false;
    private bool $silent = false;
    public string $message = '';
    public array $data = [];

    public function __construct()
    {
        $this->setSilent(true);
    }

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

    /**
     * @param  bool  $silent
     *
     * @return Response
     */
    public function setSilent(bool $silent): Response
    {
        $this->silent = $silent;
        return $this;
    }

    public function sendResponse(): void
    {
        die((string)$this);
    }

    public function __toString(): string
    {
        $data['success'] = $this->success;

        if (!empty($this->message)) {
            $data['message'] = $this->message;
        }

        if (!empty($this->data)) {
            $data['data'] = $this->data;
        }
        // @Improvement: could probably add more stuff here.
        $response = json_encode($data);
        if (!$this->silent && json_last_error() !== JSON_ERROR_NONE) {
            throw new Exception(json_last_error_msg());
        }

        if (isset($this->statusCode)) {
            $this->setStatusCode($this->statusCode);
        }
        return $response;
    }
}