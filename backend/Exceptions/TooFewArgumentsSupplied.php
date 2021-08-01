<?php

namespace App\Exceptions;

use App\Helpers\ResponseCodes;
use Exception;

class TooFewArgumentsSupplied extends Exception
{
    protected $code = ResponseCodes::HTTP_BAD_REQUEST;
    protected $message = 'Too few arguments supplied for where';
}