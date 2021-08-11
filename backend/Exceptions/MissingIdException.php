<?php

namespace App\Exceptions;

use App\Helpers\ResponseCodes;
use Exception;

class MissingIdException extends Exception
{
    protected $code = ResponseCodes::HTTP_BAD_REQUEST;
    protected $message = 'Id must be provided for this form';
}