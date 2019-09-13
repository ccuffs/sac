<?php

namespace App\Models;

use App\Models\Event;
use App\Helpers\DatabaseHelper;

class Payment extends Model {
    const PAYMENT_CONFIRMED = 3;
    const PAYMENT_AVAILABLE = 4;
    
    public static function statusToString($theStatus) {
        $aText = array(
            0 => 'Iniciado',
            1 => 'Aguardando baixa',
            2 => 'Em análise',
            3 => 'Aprovado',
            4 => 'Aprovado (D)',
            5 => 'Em disputa',
            6 => 'Estornado',
            7 => 'Cancelado'
        );	
        
        return isset($aText[$theStatus]) ? $aText[$theStatus] : '???';
    }
    
    public static function isBeingAnalyzed($thePaymentInfo) {
        return $thePaymentInfo == null || ($thePaymentInfo['status'] != 3 && $thePaymentInfo['status'] != 4);
    }
    
    public static function findByUser($theUserId) {
        $aRet = array();
        $aQuery = SELF::conn()->prepare("SELECT * FROM payment WHERE fk_user = ?");
        
        if ($aQuery->execute(array($theUserId))) {
            while ($aRow = $aQuery->fetch()) {
                $aRet[$aRow['id']] = $aRow;
            }
        }
        
        return $aRet;
    }
    
    public static function findAll() {
        $aRet = array();
        $aQuery = SELF::conn()->prepare("SELECT * FROM payment WHERE 1");
        
        if ($aQuery->execute(array())) {
            while ($aRow = $aQuery->fetch()) {
                $aRet[$aRow['id']] = $aRow;
            }
        }
        
        return $aRet;
    }

    public static function calculateUserDept($theUserInfo) {
        $aRet = 0;
        $aEvents = Event::findByUserIsAttending($theUserInfo->id);
        
        foreach($aEvents as $aId => $aInfo) {
            $aRet += $aInfo['price'];
        }
    
        $aRet += $theUserInfo->type == User::USER_LEVEL_EXTERNAL ? CONFERENCE_PRICE_EXTERNAL : CONFERENCE_PRICE;
        
        return $aRet;
    }
    
    public static function calculateUserCredit($theUserId) {
        $aRet = 0;
        $aQuery = SELF::conn()->prepare("SELECT SUM(amount) AS value FROM payment WHERE fk_user = ? AND (status = ? OR status = ?)");
        
        if ($aQuery->execute(array($theUserId, SELF::PAYMENT_CONFIRMED, SELF::PAYMENT_AVAILABLE))) {
            $aRow = $aQuery->fetch();
            $aRet = (float)$aRow['value'];
        }
        
        return $aRet;
    }
    
    public static function create($theUserId, $theAmount, $theComment) {
        $aRet = false;
        $aQuery = SELF::conn()->prepare("INSERT INTO payment (id, fk_user, date, amount, status, comment) VALUES (NULL, ?, ?, ?, ?, ?)");
        
        if ($aQuery->execute(array($theUserId, time(), $theAmount, SELF::PAYMENT_CONFIRMED, $theComment))) {
            $aRet = SELF::conn()->lastInsertId();
        }
        
        return $aRet;
    }
    
    public static function updateStatus($theId, $theStatus) {
        $aQuery = SELF::conn()->prepare("UPDATE payment SET status = ?, comment = CONCAT(comment, ?) WHERE id = ?");
        return $aQuery->execute(array($theStatus, $theStatus . '('.time().'), ', $theId));
    }
    
    public static function delete($theId) {
        $aQuery = SELF::conn()->prepare("DELETE FROM payment WHERE id = ?");
        return $aQuery->execute(array($theId));
    }
    
    public static function log($theText) {
        $aQuery = SELF::conn()->prepare("INSERT INTO payment_log (id, date, text) VALUES (NULL, ?, ?)");
        return $aQuery->execute(array(time(), $theText));
    }
    
    public static function findUsersWithPaidCredit() {
        $aRet = array();
        $aQuery = SELF::conn()->prepare("
            SELECT
                u.id, SUM(p.amount) AS paid_amount
            FROM
                users AS u
            JOIN
                payment AS p ON u.id = p.fk_user
            WHERE 
                u.id > 0 AND (p.status = 3 OR p.status = 4)
            GROUP BY
                u.id
        ");
        
        if ($aQuery->execute()) {
            while ($aRow = $aQuery->fetch()) {
                if($aRow['paid_amount'] >= 0) {
                    $aRet[$aRow['id']] = $aRow['paid_amount'];
                }
            }
        }
        
        return $aRet;
    }
}