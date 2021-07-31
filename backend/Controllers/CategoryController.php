<?php


namespace App\Controllers;


use App\Controller;
use App\DB\DbModel;
use App\Interfaces\HasModel;
use App\Middlewares\AuthMiddleware;
use App\Models\Category;

class CategoryController extends Controller implements HasModel
{
    public function index()
    {
        $this->json(true, '', Category::findAll());
    }

    function getModel(): DbModel
    {
        return new Category();
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