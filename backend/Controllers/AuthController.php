<?php


namespace App\Controllers;

use App\Application;
use App\Controller;
use App\DB\DbModel;
use App\Forms\AuthForm;
use App\Forms\Form;
use App\Middlewares\AuthMiddleware;
use App\Request;
use App\Response;
use App\Models\LoginForm;
use App\Models\User;

/**
 * Class AuthController
 * @package App\controllers
 */
class AuthController extends Controller
{

    public function getLoginForm(Request $request, Response $response) {
        $formName = Form::hasForm($request->getPath());
        if ($formName) {
            $response
                ->setSuccess(true)
                ->setData(['fields' => AuthForm::formFields()])
                ->sendResponse();
        }

        $response
            ->setSuccess(false)
            ->setMessage('Data not found')
            ->sendResponse();
    }

    public function login(Request $request, Response $response)
    {
        $loginForm = new LoginForm();
        if ($request->isPost()) {
            $loginForm->loadData($request->getBody());
            if ($loginForm->validate() && $loginForm->login()) {
                // TODO: login success should return some data so the front knows how to handle token etc.
                $response->setSuccess(true)
                         ->setData(['token' => User::getToken()])
                         ->sendResponse();
            } else {
                $response->setSuccess(false)
                         ->setMessage($loginForm->getErrorsAsString())
                         ->sendResponse();
            }
        }
    }

    /**
     * @param  Request  $request
     *
     * @return bool|array|string
     */
    public function register(Request $request): bool|array|string
    {
        $this->setLayout('auth');
        $user = new User();
        if ($request->isPost()) {
            $user->loadData($request->getBody());
            if ($user->validate() && $user->save()) {
                Application::$app->session->setFlash('success', 'Thanks for registering');
                Application::$app->response->redirect('/');
            }
            return $this->render('register', [
                'model' => $user,
            ]);
        }
        return $this->render('register', [
            'model' => $user,
        ]);
    }

    public function logout(Request $request, Response $response)
    {
        Application::$app->logout();
        $response->redirect('/');
    }

    public function profile(): bool|array|string
    {
        return $this->render('profile');
    }


    function getModel(): DbModel
    {
        // TODO: Implement getModel() method.
    }

    public function allowedNotSecureActions(): array
    {
        return ['login', 'getLoginForm'];
    }

    public function usedMiddlewares(): array
    {
        return [
            AuthMiddleware::class
        ];
    }
}