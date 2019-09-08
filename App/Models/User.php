<?php

namespace App\Models;

use App\Helpers\DatabaseHelper;

class User {
    const USER_LEVEL_UFFS = 1;
    const USER_LEVEL_EXTERNAL = 2;
    const USER_LEVEL_ADMIN = 3;

    public $id;
    public $login;
    public $cpf;
    public $name;
    public $email;
    public $type;

    public static function getById($theUserId) {
        $conn = DatabaseHelper::getConn();
        
        $user = null;
        $query = $conn->prepare("SELECT id, login, name, email, type FROM users WHERE id = ?");
        
        if ($query->execute(array($theUserId))) {	
            $data = $query->fetch();
            $user = new User();
            $user->id = $data['id'];
            $user->login = $data['login'];
            $user->name = $data['name'];
            $user->email = $data['email'];
            $user->type = $data['type'];
        }
        
        return $user;
    }

    public static function isUsernameAvailable ($username) {
        $conn = DatabaseHelper::getConn();
        
        $sql = "SELECT count(*) as amount FROM users WHERE login=:username";
        $query = $conn->prepare($sql);
        $query->execute([
            'username' => $username
        ]);
        $data = $query->fetch();
        return !$data['amount'];
    }
    
    public function findById($id) {
        $conn = DatabaseHelper::getConn();
        
        $sql = "SELECT * FROM users WHERE id = :id";
        $query = $conn->prepare($sql);
        $query->execute(['id' => $id]);
        $user_data = $query->fetch();

        if (!$user_data) return null;
        
        return SELF::newByData($user_data);
    }
    
    public function findAll() {
        $conn = DatabaseHelper::getConn();
        
        $aRet = array();
        $aQuery = $conn->prepare("SELECT id, login, name, email, type FROM users WHERE 1 ORDER BY name ASC");
        
        if ($aQuery->execute()) {	
            while ($aRow = $aQuery->fetch()) {
                $aRet[$aRow['id']] = $aRow;
            }
        }
        
        return $aRet;
    }
    
    public function isLevel($theLevel) {
        return $this->type == $theLevel;
    }
    
    public function getConferencePrice() {
        return $this->type == SELF::USER_LEVEL_EXTERNAL ? CONFERENCE_PRICE_EXTERNAL : CONFERENCE_PRICE;
    }

    public function findByUsername ($username) {
        $conn = DatabaseHelper::getConn();
        $sql = "SELECT * FROM users WHERE login = :username";
        $query = $conn->prepare($sql);
        $query->execute(['username' => $username]);
        $user_data = $query->fetch();

        if (!$user_data) {
            return null;
        }
        
        return SELF::newByData($user_data);
    }

    public function save () {
        if ($this->id) {
            $this->update();
        } else {
            $this->create();
        }
    }

    public function create () {
        $conn = DatabaseHelper::getConn();
        $sql = "INSERT INTO users SET
            name = :name,
            cpf = :cpf,
            login = :login,
            email = :email,
            type = :type
        ";
        $query = $conn->prepare($sql);
        $success = $query->execute([
            'name' => $this->name,
            'cpf' => $this->cpf,
            'login' => $this->login,
            'email' => $this->email,
            'type' => $this->type || 1
        ]);
        $this->id = $conn->lastInsertId();
        return $success;
    }

    private static function newByData ($data) {
        $data = (object) $data;
        $user = new SELF();
        $user->id = $data->id;
        $user->login = $data->login;
        $user->cpf = $data->cpf;
        $user->name = $data->name;
        $user->email = $data->email;
        $user->type = $data->type;
        return $user;
    }
}