<?php

namespace App\Interfaces;

use App\DB\DbModel;

interface HasModel
{
    public function getModel(): DbModel;
}