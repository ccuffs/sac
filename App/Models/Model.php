<?php

namespace App\Models;

use App\Helpers\DatabaseHelper;

class Model {
    public $conn;
    
    public function __contruct () {
        $this->conn = DatabaseHelper::getConn();
    }

    public static function conn () {
        return DatabaseHelper::getConn();
    }
}