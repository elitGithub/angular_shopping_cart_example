<?php


namespace App\Controllers;

use App\Controller;
use App\Interfaces\HasModel;
use App\Middlewares\AuthMiddleware;
use App\Models\Product;

class ProductsController extends Controller implements HasModel
{

    public function index()
    {
        $this->json(true, '', Product::findAll());
    }

    public function getModel(): Product
    {
        return new Product();
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