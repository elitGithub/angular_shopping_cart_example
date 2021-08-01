<?php

namespace App\Exceptions;

use App\Helpers\ResponseCodes;
use Exception;

class TooManyArgsException extends Exception
{
    protected $code = ResponseCodes::HTTP_BAD_REQUEST;
    protected $message = 'Too many arguments supplied for where';
}