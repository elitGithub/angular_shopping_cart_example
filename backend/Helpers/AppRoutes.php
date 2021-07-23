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
            'get'    => [
                '/'          => [SiteController::class, 'home'],
                'products'   => [ProductsController::class, 'index'],
                'categories' => [CategoryController::class, 'index'],
            ],
            'post'   => [
                'login' => [AuthController::class, 'login'],
            ],
            'put'    => [],
            'delete' => [],
        ];
    }
}