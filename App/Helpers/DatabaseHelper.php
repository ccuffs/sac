<?php

namespace App\Helpers;

use \PDO;

class DatabaseHelper {
    public static function getConn() {
        try {
            $conn = new PDO(DB_DSN, DB_USER, DB_PASSWORD, array(PDO::ATTR_PERSISTENT => true));
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);   
            return $conn;
        } catch (PDOException $e) {
            print "Database error! " . $e->getMessage();
            die();
        }    
    }
}

?>