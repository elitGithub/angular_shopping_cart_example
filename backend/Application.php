<?php

namespace App;

use App\DB\Database;
use App\Helpers\ResponseCodes;
use Exception;

/**
 * Class Application
 * @package eligithub\phpmvc
 */
class Application
{
    public const EVENT_BEFORE_REQUEST = 'beforeRequest';
    public const EVENT_AFTER_REQUEST = 'afterRequest';

    protected array $eventListeners = [];

    public static string $ROOT_DIR;
    public static Application $app;

    public string $layout = 'main';
    public string $userClass;
    public ?Controller $controller = null;
    public Database $db;
    public Router $router;
    public Request $request;
    public Response $response;
    public Session $session;
    public ?UserModel $user;
    public View $view;

    public function __construct(string $rootPath, array $config)
    {
        static::$ROOT_DIR = $rootPath;
        $this->setApp($this);
        $this->request = new Request();
        $this->response = new Response();
        $this->router = new Router($this->request, $this->response);
        $this->session = new Session();
        $this->db = new Database($config['db']);
        $this->userClass = $config['userClass'];
        $this->view = new View();

        $primaryValue = $this->session->get('user');
        if ($primaryValue) {
            $primaryKey = $this->userClass::primaryKey();
            $this->user = $this->userClass::findOne([$primaryKey => $primaryValue]);
        } else {
            $this->user = null;
        }
    }

    public static function isGuest(): bool
    {
        return !static::$app->user;
    }

    /**
     * Run the application - resolve the routing.
     */
    public function run()
    {
        $this->triggerEvent(static::EVENT_BEFORE_REQUEST);
        try {
            echo $this->router->resolve();
        } catch (Exception $e) {
            $code = $e->getCode();
            if (!is_numeric($code)) {
                $code = ResponseCodes::HTTP_SERVICE_UNAVAILABLE;
            }
            $this->response->setStatusCode($code);
            $this->response->setMessage($e->getMessage())->sendResponse();
        }
    }

    /**
     * @return Controller|null
     */
    public function getController(): ?Controller
    {
        return $this->controller;
    }

    /**
     * @param  Controller  $controller
     */
    public function setController(Controller $controller): void
    {
        $this->controller = $controller;
    }

    /**
     * @return Application
     */
    public static function getApp(): Application
    {
        return static::$app;
    }

    /**
     * @param  Application  $app
     */
    public static function setApp(Application $app): void
    {
        static::$app = $app;
    }

    public function login(UserModel $user): bool
    {
        $this->user = $user;
        $userId = $user->{$user->primaryKey()};
        $userData = [
            'userid'   => $userId,
            'username' => $user->username,
            'token'    => $user->token,
        ];
        $this->session->setArray($userData);
        return true;
    }

    public function logout()
    {
        $this->user = null;
        $this->session->remove('user');
    }

    public function on($eventName, $callback)
    {
        $this->eventListeners[$eventName][] = $callback;
    }

    private function triggerEvent(string $eventName)
    {
        $callbacks = $this->eventListeners[$eventName] ?? [];
        foreach ($callbacks as $callback) {
            call_user_func($callback);
        }
    }
}