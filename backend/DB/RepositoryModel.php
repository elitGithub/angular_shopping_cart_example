<?php

namespace App\DB;

use App\Application;
use App\Model;


abstract class RepositoryModel extends Model
{

    protected Database $db;

    public function __construct()
    {
        $this->db = Application::$app->db;
    }

    public function rules(): array
    {
        return [];
    }

}
