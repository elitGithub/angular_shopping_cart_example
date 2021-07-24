<?php


namespace App\Middlewares;


use App\Application;
use App\Exceptions\ForbiddenException;
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
                if (is_null(Application::$app->request->getHeaders())) {
                    throw new ForbiddenException();
                }
            }
        }
    }
}