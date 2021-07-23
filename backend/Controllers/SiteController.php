<?php


namespace App\Controllers;

use App\Application;
use App\Controller;
use App\DB\DbModel;
use App\Middlewares\AuthMiddleware;
use App\Request;
use App\Response;
use App\Models\ContactForm;

/**
 * Class SiteController
 * @package App\controllers
 */
class SiteController extends Controller
{
	public function home(): bool|array|string
	{
		$params = [
			'name'      => 'Eli',
			'pageTitle' => 'My super awesome app',
		];

		return $this->render('home', $params);
	}

	public function options() {
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
			'model' => $contact
		]);
	}

    function getModel(): DbModel
    {
        // TODO: Implement getModel() method.
    }

    public function allowedNotSecureActions(): array
    {
        return ['login'];
    }

    public function usedMiddlewares(): array
    {
        return [
            AuthMiddleware::class
        ];
    }
}