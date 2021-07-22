<?php


namespace App\Controllers;


use App\Controller;
use App\DB\DbModel;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        $this->json(true, '',  Category::findAll());
    }

    function getModel(): DbModel
    {
        return new Category();
    }
}