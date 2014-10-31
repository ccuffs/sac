<?php

require_once dirname(__FILE__).'/config.php';

define('PAYMENT_CONFIRMED', 	3);
define('PAYMENT_AVAILABLE', 	4);

function paymentStatusToString($theStatus) {
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

function paymentIsBeingAnalyzed($thePaymentInfo) {
	return $thePaymentInfo == null || ($thePaymentInfo['status'] != 3 && $thePaymentInfo['status'] != 4);
}

function paymentFindByUser($theUserId) {
	global $gDb;
	
	$aRet = array();
	$aQuery = $gDb->prepare("SELECT * FROM payment WHERE fk_user = ?");
	
	if ($aQuery->execute(array($theUserId))) {
		while ($aRow = $aQuery->fetch()) {
			$aRet[$aRow['id']] = $aRow;
		}
	}
	
	return $aRet;
}

function paymentCalculateUserCredit($theUserId) {
	global $gDb;
	
	$aRet = 0;
	$aQuery = $gDb->prepare("SELECT SUM(amount) AS value FROM payment WHERE fk_user = ? AND (status = ? OR status = ?)");
	
	if ($aQuery->execute(array($theUserId, PAYMENT_CONFIRMED, PAYMENT_AVAILABLE))) {
		$aRow = $aQuery->fetch();
		$aRet = $aRow['value'];
	}
	
	return $aRet;
}

function paymentCreate($theUserId, $theAmount) {
	global $gDb;
	
	$aRet = false;
	$aQuery = $gDb->prepare("INSERT INTO payment (id, fk_user, date, amount, status, comment) VALUES (NULL, ?, ?, ?, ?, ?)");
	
	if ($aQuery->execute(array($theUserId, time(), $theAmount, 1, ''))) {
		$aRet = $gDb->lastInsertId();
	}
	
	return $aRet;
}

function paymentUpdateStatus($theId, $theStatus) {
	global $gDb;
	
	$aQuery = $gDb->prepare("UPDATE payment SET status = ?, comment = CONCAT(comment, ?) WHERE id = ?");
	return $aQuery->execute(array($theStatus, $theStatus . '('.time().'), ', $theId));
}

function paymentLog($theText) {
	global $gDb;
	
	$aQuery = $gDb->prepare("INSERT INTO payment_log (id, date, text) VALUES (NULL, ?, ?)");
	return $aQuery->execute(array(time(), $theText));
}

?>