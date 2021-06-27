<?php


namespace App\Controllers;

use eligithub\phpmvc\Application;
use eligithub\phpmvc\Controller;
use eligithub\phpmvc\Request;
use eligithub\phpmvc\Response;
use App\Models\ContactForm;

/**
 * Class SiteController
 * @package App\controllers
 */
class SiteController extends Controller
{
	public function home(): bool|array|string
	{
		return 'Hello from home';
	}

}