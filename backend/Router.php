<?php

namespace App;

use App\Exceptions\NotFoundException;
use JetBrains\PhpStorm\Pure;

/**
 * Class Router
 * @package eligithub\phpmvc
 */
class Router
{
    protected Application $app;

    /**
     * @var array
     */
    protected array $routes = [];
    protected array $supportedMethods = ['get', 'post', 'put', 'delete'];

    /**
     * Router constructor.
     *
     * @param  Request  $request
     * @param  Response  $response
     */
    public function __construct(public Request $request, public Response $response)
    {
        $this->app = Application::getApp();
    }

    /**
     * @param $path
     * @param $callback
     */
    public function get($path, $callback)
    {
        $this->routes['get'][$path] = $callback;
    }

    /**
     * @param $path
     * @param $callback
     */
    public function post($path, $callback)
    {
        $this->routes['post'][$path] = $callback;
    }

    /**
     * @param $path
     * @param $callback
     */
    public function put($path, $callback)
    {
        $this->routes['post'][$path] = $callback;
    }

    /**
     * @param $path
     * @param $callback
     */
    public function delete($path, $callback)
    {
        $this->routes['post'][$path] = $callback;
    }

    /**
     * @return mixed
     * @throws NotFoundException
     */
    public function resolve(): mixed
    {
        $path = $this->request->getPath();
        $method = $this->request->method();
        $callback = $this->routes[$method][$path] ?? false;
        if (!$callback) {
            throw new NotFoundException();
        }
        if (is_string($callback)) {
            return $this->app->view->renderView($callback);
        }

        if (is_array($callback)) {
            $callback[0] = new $callback[0]();
            $this->app->setController($callback[0]);
            $this->app->controller->action = $callback[1];
            foreach ($this->app->controller->getMiddlewares() as $middleware) {
                $middleware->execute();
            }
        }
        return call_user_func($callback, $this->request, $this->response);
    }

    /**
     * All your base are belong to us
     * Register the application routes here
     * @TODO: Maybe make this more diverse/use separate files, as in a larger application, this thing will become a
     *     monster.
     */
    public function registerRoutes(array $routes = [])
    {
        // user defined routes
        if (!empty($routes)) {
            foreach ($this->supportedMethods as $method) {
                if (isset($routes[$method])) {
                    foreach ($routes[$method] as $path => $callback) {
                        $this->{$method}($path, $callback);
                    }
                }
            }
        }
    }
}