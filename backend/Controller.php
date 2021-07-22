<?php


namespace App;

use App\DB\DbModel;
use App\Middlewares\AuthMiddleware;
use App\Middlewares\BaseMiddleware;

/**
 * Class Controller
 * @package eligithub\phpmvc
 */
abstract class Controller
{
    public string $layout = 'main';
    public array $action = [];

    public function __construct()
    {
        $this->registerMiddleware(new AuthMiddleware($this->action));
    }



	/**
	 * @var BaseMiddleware[]
	 */
	protected array $middlewares = [];

	public function json(bool $success = false, string $message = '', array $data = []) {
	    Application::$app->response
            ->setSuccess($success)
            ->setMessage($message
            )->setData($data)
             ->sendResponse();
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