<?php


namespace App\Controllers;

use App\Application;
use App\Controller;
use App\DB\DbModel;
use App\Exceptions\TooFewArgumentsSupplied;
use App\Exceptions\TooManyArgsException;
use App\Helpers\Colors;
use App\Helpers\JWTHelper;
use App\Interfaces\HasModel;
use App\Middlewares\AuthMiddleware;
use App\Models\Dashboard;
use App\Request;
use App\Response;
use App\Models\ContactForm;

/**
 * Class SiteController
 * @package App\controllers
 */
class SiteController extends Controller
{
    /**
     * @throws TooManyArgsException
     * @throws TooFewArgumentsSupplied
     */
    public function home(Request $request, Response $response)
    {
        // TODO: dashboard in front
        $dashboard = new Dashboard();
        $data = [
            'cards'    => [
                [
                    'value' => $dashboard->totalOrders(),
                    'name' => 'Total Orders',
                    'color' => Colors::FRUIT_SALAD
                ],
                [
                    'value' => $dashboard->totalCompletedOrders(),
                    'name' => 'Completed Orders',
                    'color' => Colors::CINNABAR,
                ],
                [
                    'value' => $dashboard->totalPendingOrders(),
                    'name' => 'Pending Orders',
                    'color' => Colors::WAFER,
                ],
                [
                    'value' => $dashboard->clientsCount(),
                    'name' => 'Total Registered Clients',
                    'color' => Colors::JORDY_BLUE,
                ],
                [
                    'value' => $dashboard->productsCount(),
                    'name' => 'Total Products',
                    'color' => Colors::BLIZZARD_BLUE,
                ],
                [
                    'value' => $dashboard->usersCount(),
                    'name' => 'System Users',
                    'color' => Colors::ROUGE,
                ],
            ],
            'metaData' => [
                'primaryColor' => Colors::MIDNIGHT_EXPRESS,
            ],
        ];
        $this->json(success: true, data: $data);
    }

    public function options()
    {
        http_response_code(200);
        header("Access-Control-Allow-Origin: http://localhost:4200");
        header("Content-Type: application/json; charset=UTF-8");
        header("Access-Control-Allow-Methods: POST, DELETE, OPTIONS");
        header("Access-Control-Max-Age: 3600");
        header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    }

    public function contact(Request $request, Response $response): bool|array|string
    {
        $contact = new ContactForm();
        if ($request->isPost()) {
            $contact->loadData($request->getBody());
            if ($contact->validate() && $contact->send()) {
                Application::$app->session->setFlash('success', 'Thanks for contact us');
                $response->redirect('/contact');
            }
        }

        return $this->render('contact', [
            'model' => $contact,
        ]);
    }

    public function allowedNotSecureActions(): array
    {
        return ['login'];
    }

    public function usedMiddlewares(): array
    {
        return [
            AuthMiddleware::class,
        ];
    }
}