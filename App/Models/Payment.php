<?php

namespace App\Models;

use App\Models\Event;
use App\Helpers\DatabaseHelper;

class Payment extends Model {
    protected $table = "payment";

    public $id;
    public $fk_user;
    public $date;
    public $amount;
    public $status;
    public $comment;
    public $user;

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

    public static function findById ($id) {
        $sql = "SELECT *, p.id as id FROM payment AS p
            INNER JOIN users AS u ON p.fk_user = u.id
            WHERE p.id = :id
        ";
        $query = SELF::conn()->prepare($sql);
        
        $payment = null;
        if ($query->execute(['id' => $id])) {
            if($data = $query->fetch()) {
                $payment = SELF::newByDataWithUser($data);
            }
        }
        
        return $payment;
    }
    
    public static function findAll() {
        $list = [];
        $sql = "SELECT *, p.id as id FROM payment AS p
            INNER JOIN users AS u ON p.fk_user = u.id
        ";
        $query = SELF::conn()->prepare($sql);
        
        if ($query->execute()) {
            while ($data = $query->fetch()) {
                $list[] = SELF::newByDataWithUser($data);
            }
        }
        
        return $list;
    }

    public static function calculateUserDept($user) {
        $aRet = 0;
        $aEvents = Event::findByUserIsAttending($user->id);
        
        foreach($aEvents as $aId => $aInfo) {
            $aRet += $aInfo['price'];
        }
    
        $aRet += $user->type == User::USER_LEVEL_EXTERNAL ? CONFERENCE_PRICE_EXTERNAL : CONFERENCE_PRICE;
        
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
    
    public function create() {
        $sql = "INSERT INTO payment (fk_user , amount , comment , date , status) VALUES
                    (:fk_user, :amount, :comment, :date, :status)";

        $query = SELF::conn()->prepare($sql);

        $query->bindParam('fk_user', $this->fk_user);
        $query->bindParam('amount', $this->amount);
        $query->bindParam('comment', $this->comment);
        $query->bindParam('date', $this->date);
        $query->bindParam('status', $this->status);

        $result = $query->execute();
        if (!$result) return false;
        return SELF::conn()->lastInsertId(); 
    }
    
    public static function updateStatus($theId, $theStatus) {
        $aQuery = SELF::conn()->prepare("UPDATE payment SET status = ?, comment = CONCAT(comment, ?) WHERE id = ?");
        return $aQuery->execute(array($theStatus, $theStatus . '('.time().'), ', $theId));
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

    private static function newByData ($data) {
        $data = (object) $data;
        $event = new SELF();
        $event->id = $data->id;
        $event->fk_user = $data->fk_user;
        $event->date = $data->date;
        $event->amount = $data->amount;
        $event->status = $data->status;
        $event->comment = $data->comment;
        return $event;
    }

    private static function newByDataWithUser ($data) {
        $data = (object) $data;
        $event = new SELF();
        $event->id = $data->id;
        $event->fk_user = $data->fk_user;
        $event->date = $data->date;
        $event->amount = $data->amount;
        $event->status = $data->status;
        $event->comment = $data->comment;
        $event->user = User::newByData(array_merge((array) $data, ['id' => $data->fk_user]));
        return $event;
    }
}