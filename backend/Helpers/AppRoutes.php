<?php


namespace App\Helpers;


use App\Controllers\AuthController;
use App\Controllers\CategoryController;
use App\Controllers\ProductsController;
use App\Controllers\SiteController;

class AppRoutes
{
    public static function routes(): array
    {
        return [
            'options' => [
                [SiteController::class, 'options'],
            ],
            'get'     => [
                '/'          => [SiteController::class, 'home'],
                'products'   => [ProductsController::class, 'index'],
                'categories' => [CategoryController::class, 'index'],
                'login'      => [AuthController::class, 'isLoggedIn'],
            ],
            'post'    => [
                'login'  => [AuthController::class, 'login'],
                'logout' => [AuthController::class, 'logout'],
            ],
            'put'     => [],
            'delete'  => [],
        ];
    }
}