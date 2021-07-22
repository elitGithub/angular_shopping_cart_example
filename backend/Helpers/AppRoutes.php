<?php


namespace App\Helpers;


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
            'post'   => [],
            'put'    => [],
            'delete' => [],
        ];
    }
}