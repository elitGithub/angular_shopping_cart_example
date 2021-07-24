<?php


namespace App\Middlewares;


use App\Application;

abstract class BaseMiddleware
{

    protected array $secureActions;

    public function __construct(public array $actions = [])
    {
        foreach ($this->actions as $action) {
            if (!in_array($action, Application::$app->getController()->allowedNotSecureActions())) {
                $this->secureActions[] = $action;
            }
        }
    }

    abstract public function execute();

}