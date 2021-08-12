<?php

namespace App\Migrations;

use App\Migration;

class m010_MakeSoundex extends Migration
{

    public array $tables = [
        'products'   => 'name',
        'categories' => 'name',
    ];

    public function up()
    {
        foreach ($this->tables as $table => $column) {
            $result = $this->db->preparedQuery("SELECT $column FROM $table");
            foreach ($this->db->fetchAllColumns($result) as $string) {
                $soundsLike = soundex($string);
                $this->db->preparedQuery("UPDATE $table SET sounds_like = ? WHERE $column = BINARY ?", [$soundsLike, $string]);
            }
        }
    }

    public function down()
    {
        // TODO: Implement down() method.
    }
}