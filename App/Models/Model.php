<?php

namespace App\Models;

use App\Helpers\DatabaseHelper;

class Model {
    public static function conn () {
        return DatabaseHelper::getConn();
    }

    public function setAttr($attr, $value) {
        if (isset($value) && $value != null) {
            $this->$attr = $value;
        }
    }
}