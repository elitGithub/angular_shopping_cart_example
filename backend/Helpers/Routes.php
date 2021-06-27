<?php


namespace App\Helpers;


use App\Controllers\SiteController;

class Routes
{
	public static function appRoutes(): array
	{
		return [
			'get'    => [
				[
					'path'     => '/',
					'callback' => [SiteController::class, 'home']
				],
			],
			'post'   => [],
			'put'    => [],
			'delete' => [],
		];
	}

}