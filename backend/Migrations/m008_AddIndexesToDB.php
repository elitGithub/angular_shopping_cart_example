<?php

namespace App\Migrations;

use App\Migration;

class m008_AddIndexesToDB extends Migration
{
    public const INDEXES = [
        'users'      => [
            'CREATE UNIQUE INDEX idx_username ON users (username);',
            'CREATE UNIQUE INDEX idx_email ON users (email);',
            'CREATE INDEX idx_role ON users (role_id);',
            'ALTER TABLE users ADD FOREIGN KEY (role_id) REFERENCES roles(id) ON DELETE CASCADE;'
        ],
        'products'   => [
            'CREATE UNIQUE INDEX item_in_category ON products (name, category_id);',
            'ALTER TABLE products ADD FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE;',
        ],
        'categories' => [
            'CREATE UNIQUE INDEX idx_category_name ON categories (name);',
        ],
        'clients'    => [
            'CREATE UNIQUE INDEX idx_email ON clients (email);',
        ],
        'orders'     => [
            'ALTER TABLE orders ADD FOREIGN KEY (client_id) REFERENCES clients(id) ON DELETE CASCADE;',
        ],
        'carts'      => [
            'ALTER TABLE carts ADD FOREIGN KEY (client_id) REFERENCES clients(id) ON DELETE CASCADE;',
            'ALTER TABLE carts ADD FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE;',
            'ALTER TABLE carts ADD FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE;',
        ],
        'roles'      => [
            'CREATE UNIQUE INDEX role_id ON roles (id);',
        ],
    ];

    public function up()
    {
        foreach (static::INDEXES as $tableName => $queries) {
            foreach ($queries as $query) {
                $stmt = $this->db->prepare($query);
                $stmt->execute();
            }
        }
    }

    public function down()
    {
        // No down - the down for  installation drops the tables
    }
}