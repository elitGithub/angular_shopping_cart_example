<?php


namespace App\Middlewares;


use App\Application;
use App\Exceptions\ForbiddenException;
use App\Helpers\JWTHelper;
use App\Request;

class AuthMiddleware extends BaseMiddleware
{


    /**
     * @throws ForbiddenException
     */
    public function execute()
    {
        if (Application::isGuest()) {
            if (!empty($this->secureActions)) {
                // Check for token and validity
                if (!Application::$app->session->validateSession()) {
                    throw new ForbiddenException();
                }
            }
        }
    }
}