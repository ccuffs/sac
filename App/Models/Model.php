<?php

namespace App\Models;

use App\Helpers\DatabaseHelper;

class Model {
    public static function conn () {
        return DatabaseHelper::getConn();
    }
}