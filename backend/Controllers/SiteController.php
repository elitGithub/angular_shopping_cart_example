<?php


namespace App\Controllers;

use App\Application;
use App\Controller;
use App\DB\DbModel;
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
}