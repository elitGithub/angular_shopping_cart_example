<?php


namespace App\Controllers;

use App\Application;
use App\Controller;
use App\DB\DbModel;
use App\Helpers\JWTHelper;
use App\Helpers\PlaceHolders;
use App\Interfaces\HasModel;
use App\Middlewares\AuthMiddleware;
use App\Request;
use App\Response;
use App\Models\LoginForm;
use App\Models\User;

/**
 * Class AuthController
 * @package App\controllers
 */
class AuthController extends Controller implements HasModel
{

    public function getUserData(Request $request, Response $response)
    {
        $headers = $request->getHeaders();

        $payload = JWTHelper::parseToken($headers['Authorization']);
        if (isset($payload['user_id'])) {
            $user = User::findOne([User::primaryKey() => $payload['user_id']]);
            $response
                ->setSuccess(true)
                ->setData([
                    'user' => [
                        'username'     => $user->username,
                        'display_name' => $user->getDisplayName(),
                        'user_image'   => $user->user_image ?? PlaceHolders::AVATAR_PLACEHOLDER,
                        'description'  => $user->description,
                        'role'         => $user->getRole(),
                    ],
                ])
                ->sendResponse();
        }
        $response
            ->setSuccess(false)
            ->setMessage('User not found')
            ->setData(['mustLogin' => true])
            ->sendResponse();
    }

    public function isLoggedIn(Request $request, Response $response)
    {
        // TODO: validate this part
        $session = Application::$app->session;
        if ($session->validateSession()) {
            $user = User::findOne([User::primaryKey() => $session->get('userid')]);
            $response
                ->setSuccess(true)
                ->setData([
                    'user' => [
                        'username'     => $user->username,
                        'display_name' => $user->getDisplayName(),
                        'user_image'   => $user->user_image ?? PlaceHolders::AVATAR_PLACEHOLDER,
                        'description'  => $user->description,
                        'role'         => $user->getRole(),
                    ],
                ])
                ->sendResponse();
        }

        $response
            ->setSuccess(false)
            ->setMessage('User is not logged in')
            ->setData(['mustLogin' => true])
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
                         ->setData([
                             'token'    => User::getToken(),
                             'userData' => $loginForm->user->info(),
                         ])
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
        // TODO: add token validation and flushing
        Application::$app->logout();
        $response->setSuccess(true)->sendResponse();
    }

    public function profile(): bool|array|string
    {
        return $this->render('profile');
    }


    function getModel(): DbModel
    {
        return new User();
    }

    public function allowedNotSecureActions(): array
    {
        return ['login', 'isLoggedIn'];
    }

    public function usedMiddlewares(): array
    {
        return [
            AuthMiddleware::class,
        ];
    }
}