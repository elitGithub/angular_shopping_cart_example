<?php


namespace App\Controllers;

use App\Controller;
use App\Models\Product;

class ProductsController extends Controller
{

    public function index()
    {
        $this->json(true, '',  Product::findAll());
    }

    public function getModel(): Product
    {
        return new Product();
    }

}