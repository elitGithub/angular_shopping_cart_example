<?php


namespace App\Controllers;

use App\Controller;
use App\Interfaces\HasModel;
use App\Middlewares\AuthMiddleware;
use App\Models\Product;
use App\Request;
use App\Response;

class ProductsController extends Controller implements HasModel
{

    public function index ()
    {
        $this->json(success: true, data: Product::findAll());
    }

    public function form (Request $request, Response $response)
    {
        if ($request->isGet()) {
            $id = $request->getBody()['id'] ?? null;
            if (is_null($id)) {
                $data = [
                    'title'  => 'Create New Product',
                    'fields' => $this->getModel()->createForm(),
                ];
                $this->json(success: true, data: $data);
            }
        }
    }

    public function getModel () : Product
    {
        return new Product();
    }

    public function allowedNotSecureActions () : array
    {
        return ['login'];
    }

    public function usedMiddlewares () : array
    {
        return [
            AuthMiddleware::class,
        ];
    }
}