<?php

namespace App\Models;


class User {
    const USER_LEVEL_UFFS = 1;
    const USER_LEVEL_EXTERNAL = 2;
    const USER_LEVEL_ADMIN = 3;

    public $id;
    public $login;
    public $name;
    public $email;
    public $type;

    public static function getById($theUserId) {
        global $gDb;
        
        $user = null;
        $query = $gDb->prepare("SELECT id, login, name, email, type FROM users WHERE id = ?");
        
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
    
    public function findByIds($theUserIds) {
        global $gDb;
        
        $aUsers = array();
        $aIds = '';
    
        foreach($theUserIds as $aKey => $aValue) {
            $theUserIds[$aKey] = (int)$aValue;
        }
        $aIds = implode(',', $theUserIds);
    
        $aQuery = $gDb->prepare("SELECT id, login, name, email, type FROM users WHERE id IN (".$aIds.")");
        
        if(count($theUserIds) > 0) {
            if ($aQuery->execute()) {	
                while ($aRow = $aQuery->fetch()) {
                    $aUsers[$aRow['id']] = $aRow;
                }
            }
        }
        return $aUsers;
    }
    
    public function findAll() {
        global $gDb;
        
        $aRet = array();
        $aQuery = $gDb->prepare("SELECT id, login, name, email, type FROM users WHERE 1 ORDER BY name ASC");
        
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
    
    public function loginfyName($theName) {
        $aParts = explode(' ', strtolower($theName));
        $aName  = '';
        
        for ($i = 0; $i < count($aParts) - 1; $i++) {
            $aName .= strlen($aParts[$i]) >= 1 ? $aParts[$i][0] : '';
        }
        
        $aName .= $aParts[$i];
        return $aName;
    }
}