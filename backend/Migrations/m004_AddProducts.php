<?php


namespace App\Migrations;


use App\Migration;
use App\Models\Product;

class m004_AddProducts extends Migration
{

    public const EXAMPLE_PRODUCTS = [
        [
            'name'        => 'Apples',
            'description' => 'Very Tasty',
            'price'       => 8.99,
            'category_id' => 1,
            'in_stock'    => 1,
        ],
        [
            'name'        => 'Oranges',
            'description' => 'Very Orangy',
            'price'       => 8.99,
            'category_id' => 1,
            'in_stock'    => 1,
        ],
        [
            'name'        => 'Nectarinas',
            'description' => 'Very Yellow',
            'price'       => 8.99,
            'category_id' => 1,
            'in_stock'    => 1,
        ],
        [
            'name'        => 'Cucumbers',
            'description' => 'Very Green',
            'price'       => 8.99,
            'category_id' => 2,
            'in_stock'    => 1,
        ],
        [
            'name'        => 'Tomatoes',
            'description' => 'Very Red',
            'price'       => 8.99,
            'category_id' => 2,
            'in_stock'    => 1,
        ],
    ];

    public function up()
    {
        foreach (static::EXAMPLE_PRODUCTS as $item) {
            $product = new Product();
            $product->loadData($item);
            $product->save();
        }
    }

    public function down()
    {
        $names = array_column(static::EXAMPLE_PRODUCTS, 'name');
        $values = join(',', $names);
        $sql = "DELETE FROM products WHERE name IN ($values)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
    }
}