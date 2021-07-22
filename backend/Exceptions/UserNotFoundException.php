<?php


namespace App\Exceptions;


use App\Helpers\ResponseCodes;
use Exception;

class UserNotFoundException extends Exception
{
    protected $code = ResponseCodes::HTTP_NOT_FOUND;
    protected $message = 'User not found';

}