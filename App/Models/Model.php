<?php

namespace App\Models;

use App\Helpers\DatabaseHelper;

class Model {
    protected $primaryKey = "id";

    public static function conn () {
        return DatabaseHelper::getConn();
    }

    public function setAttr($attr, $value) {
        if (isset($value) && $value != null) {
            $this->$attr = $value;
        }
    }

    public function save () {
        if ($this->id) {
            return $this->update();
        } else {
            return $this->create();
        }
    }

    public function delete () {
        if (!isset($this->table)) return false; 
        $sql = "DELETE FROM `$this->table` WHERE `$this->primaryKey` = :id";
        $query = SELF::conn()->prepare($sql);
        $query->bindParam('id', $this->{$this->primaryKey});
        return $query->execute();
    }
}