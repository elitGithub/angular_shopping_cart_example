<?php


namespace App;

use App\DB\DbModel;
use App\Interfaces\Auth;
use App\Middlewares\BaseMiddleware;

/**
 * Class Controller
 * @package eligithub\phpmvc
 */
abstract class Controller implements Auth
{
    public string $layout = 'main';


    /**
     * @var BaseMiddleware[]
     */
    protected array $middlewares = [];

    public function json(bool $success = false, string $message = '', array $data = [])
    {
        Application::$app->response
            ->setSuccess($success)
            ->setMessage($message)
            ->setData($data)
            ->sendResponse();
    }

    public function __set(string $name, $value): void
    {
        if ($name === 'action') {
            $action = $value;
            foreach ($this->usedMiddlewares() as $middleware) {
                $this->registerMiddleware(new $middleware([$action]));
            }
        } else {
            $this->$name = $value;
        }
    }

    public function __get(string $name)
    {
        return $this->$name;
    }

    abstract function getModel(): DbModel;

    public function render($view, $params = []): bool|array|string
    {
        return Application::$app->view->renderView($view, $params);
    }

    public function setLayout($layout)
    {
        $this->layout = $layout;
    }

    public function registerMiddleware(BaseMiddleware $middlewares)
    {
        $this->middlewares[] = $middlewares;
    }

    /**
     * @return BaseMiddleware[]
     */
    public function getMiddlewares(): array
    {
        return $this->middlewares;
    }
}