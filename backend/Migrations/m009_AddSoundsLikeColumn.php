<?php

namespace App\Migrations;

use App\Migration;

class m009_AddSoundsLikeColumn extends Migration
{
    public const COLS_DATA = [
        [
            'table' => 'products',
            'after' => 'in_stock',
        ],
        [
            'table' => 'categories',
            'after' => 'description',
        ],
    ];

    public function up()
    {
        foreach (static::COLS_DATA as $column) {
            $this->db->preparedQuery("ALTER TABLE {$column['table']} ADD COLUMN sounds_like VARCHAR(255) AFTER {$column['after']}");
        }
    }

    public function down()
    {
        foreach (static::COLS_DATA as $column) {
            $this->db->preparedQuery("ALTER TABLE {$column['table']} DROP IF EXISTS sounds_like");
        }
    }
}