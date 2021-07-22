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
        $stmt = $this->db->prepare("INSERT INTO categories (name, description) VALUES $values");
        $stmt->execute();
    }

    public function down()
    {
        $toDelete = join(',', array_map(fn($m) => "'$m'", $this->categories));
        $stmt = $this->db->prepare("DELETE FROM categories WHERE categories.name IN ($toDelete)");
        $stmt->execute();
    }
}