<?php


namespace App\Migrations;


use App\Migration;

class m003_AddCategories extends Migration
{
    public array $categories = [
        'Fruits',
        'Vegetables',
        'Clothes',
        'Electronics',
    ];

    public function up()
    {
        $values = join(',', array_map(fn($cat) => "('$cat', 'A new category')", $this->categories));
        $this->db->preparedQuery("INSERT INTO categories (name, description) VALUES $values");
    }

    public function down()
    {
        // Installation removes the table
    }
}