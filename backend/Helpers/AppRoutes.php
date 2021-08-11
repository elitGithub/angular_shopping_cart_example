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
                '/'             => [SiteController::class, 'home'],
                'products'      => [ProductsController::class, 'index'],
                'products-form' => [ProductsController::class, 'form'],
                'categories'    => [CategoryController::class, 'index'],
                'getUserData'   => [AuthController::class, 'getUserData'],
            ],
            'post'    => [
                'login'      => [AuthController::class, 'login'],
                'isLoggedIn' => [AuthController::class, 'isLoggedIn'],
                'logout'     => [AuthController::class, 'logout'],
            ],
            'put'     => [],
            'delete'  => [],
        ];
    }
}