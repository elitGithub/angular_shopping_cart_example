<?php


namespace App\Exceptions;


use App\Helpers\ResponseCodes;
use Exception;

class ForbiddenException extends Exception
{
	protected $code = ResponseCodes::HTTP_FORBIDDEN;
	protected $message = 'You don\'t have permission to access this page';

}