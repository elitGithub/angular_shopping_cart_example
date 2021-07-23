<?php


namespace App\Middlewares;


use App\Application;
use App\Exceptions\ForbiddenException;

class AuthMiddleware extends BaseMiddleware
{

    private array $secureActions;

    public function __construct(public array $actions = [])
    {
        $this->secureActions = array_diff(Application::$app?->getController()?->allowedNotSecureActions(),
            $this->actions);
    }

    /**
     * @throws ForbiddenException
     */
    public function execute()
    {
        if (Application::isGuest()) {
            if (!empty($this->secureActions)) {
                throw new ForbiddenException();
            }
        }
    }
}