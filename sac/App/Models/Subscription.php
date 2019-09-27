<?php

namespace App\Models;

use App\Models\User;
use App\Models\Event;

class Subscription extends Model {
    public static function findByUserId($theUserId) {
        $aRet = array();
        $aQuery = SELF::conn()->prepare("SELECT * FROM attending WHERE fk_user = ?");
        
        if ($aQuery->execute(array($theUserId))) {
            while ($aRow = $aQuery->fetch()) {
                $aRet[$aRow['fk_event']] = $aRow;
            }
        }
        
        return $aRet;
    }
    
    public static function findUsersByEventId($theEventId) {
        $aRet = array();
        $aQuery = SELF::conn()->prepare("SELECT * FROM attending WHERE fk_event = ? ORDER BY date ASC");
        
        if ($aQuery->execute(array($theEventId))) {
            while ($aRow = $aQuery->fetch()) {
                $aRet[$aRow['fk_user']] = $aRow;
            }
        }
        
        return $aRet;
    }
    
    public static function doesUserHavePaidConferencePass($theUserId) {
        $user 			= User::getById($theUserId);
        $aPaidCredit 	= Payment::calculateUserCredit($theUserId);
        
        return $user != null && $aPaidCredit >= $user->getConferencePrice();
    }
    
    
    public function add($theUserId, $theEventId, $thePaid) {
        $aRet 		= null; 
        $aEvent 	= Event::getById($theEventId);	
        
        if ($aEvent == null) {
            throw new \Exception('Evento desconhecido');
        }
        
        if ($aEvent['ghost'] != 0) {
            throw new \Exception('Evento fantasma');
        }
        
        if (!SELF::doesUserHavePaidConferencePass($theUserId)) {
            throw new \Exception('Sua inscrição ainda não foi paga. Você não pode se increver em atividades.');
        }
        
        if ($aEvent['capacity'] != 0 && Subscription::countEventAttendants($theEventId) >= ($aEvent['capacity'] + $aEvent['waiting_capacity'])) {
            throw new \Exception('Não há mais vagas para essa atividade');
        }
        
        $aAttendings = Subscription::findByUserId($theUserId);
        
        if (isset($aAttendings[$theEventId])) {
            throw new \Exception('Você já está inscrito nessa atividade');
        }
        
        $aQuery = SELF::conn()->prepare("INSERT INTO attending (fk_event, fk_user, date, paid) VALUES (?, ?, ?, ?)");
        $aRet 	= $aQuery->execute(array($theEventId, $theUserId, time(), $thePaid));
        
        return $aRet;
    }
    
    public function remove($theUserId, $theEventId) {
        $aRet = null;
        $aQuery = SELF::conn()->prepare("DELETE FROM attending WHERE fk_user = ? AND fk_event = ?");
        
        $aRet = $aQuery->execute(array($theUserId, $theEventId));
        
        return $aRet;
    }
    
    public static function countEventAttendants($theEventId) {
        $aRet = 0;
        $aQuery = SELF::conn()->prepare("SELECT COUNT(*) AS total FROM attending WHERE fk_event = ?");
        
        if ($aQuery->execute(array($theEventId))) {
            $aRow = $aQuery->fetch();
            $aRet = $aRow['total'];
        }
        
        return $aRet;
    }
}