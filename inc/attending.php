<?php

require_once dirname(__FILE__).'/config.php';

function attendingFindByUserId($theUserId) {
	global $gDb;
	
	$aRet = array();
	$aQuery = $gDb->prepare("SELECT * FROM attending WHERE fk_user = ?");
	
	if ($aQuery->execute(array($theUserId))) {
		while ($aRow = $aQuery->fetch()) {
			$aRet[$aRow['fk_event']] = $aRow;
		}
	}
	
	return $aRet;
}

function attendingFindUsersByEventId($theEventId) {
	global $gDb;
	
	$aRet = array();
	$aQuery = $gDb->prepare("SELECT * FROM attending WHERE fk_event = ? ORDER BY date ASC");
	
	if ($aQuery->execute(array($theEventId))) {
		while ($aRow = $aQuery->fetch()) {
			$aRet[$aRow['fk_user']] = $aRow;
		}
	}
	
	return $aRet;
}

function attendingCalculateUserDept($theUserInfo) {
	$aRet = 0;
	$aEvents = eventFindByUserIsAttending($theUserInfo['id']);
	
	foreach($aEvents as $aId => $aInfo) {
		$aRet += $aInfo['price'];
	}

	$aRet += $theUserInfo['type'] == USER_LEVEL_EXTERNAL ? CONFERENCE_PRICE_EXTERNAL : CONFERENCE_PRICE;
	
	return $aRet;
}

function attendingAdd($theUserId, $theEventId, $thePaid) {
	global $gDb;
	
	$aRet 		= null; 
	$aEvent 	= eventGetById($theEventId);	
	
	if ($aEvent == null) {
		throw new Exception('Evento desconhecido');
	}
	
	if ($aEvent['ghost'] != 0) {
		throw new Exception('Evento fantasma');
	}
	
	if ($aEvent['capacity'] != 0 && attendingCountEventAttendants($theEventId) >= ($aEvent['capacity'] + $aEvent['waiting_capacity'])) {
		throw new Exception('Não há mais vagas para essa atividade');
	}
	
	$aAttendings = attendingFindByUserId($theUserId);
	
	if (isset($aAttendings[$theEventId])) {
		throw new Exception('Você já está inscrito nessa atividade');
	}
	
	$aQuery = $gDb->prepare("INSERT INTO attending (fk_event, fk_user, date, paid) VALUES (?, ?, ?, ?)");
	$aRet 	= $aQuery->execute(array($theEventId, $theUserId, time(), $thePaid));
	
	return $aRet;
}

function attendingRemove($theUserId, $theEventId) {
	global $gDb;
	
	$aRet = null;
	$aQuery = $gDb->prepare("DELETE FROM attending WHERE fk_user = ? AND fk_event = ?");
	
	$aRet = $aQuery->execute(array($theUserId, $theEventId));
	
	return $aRet;
}

function attendingCountEventAttendants($theEventId) {
	global $gDb;
	
	$aRet = 0;
	$aQuery = $gDb->prepare("SELECT COUNT(*) AS total FROM attending WHERE fk_event = ?");
	
	if ($aQuery->execute(array($theEventId))) {
		$aRow = $aQuery->fetch();
		$aRet = $aRow['total'];
	}
	
	return $aRet;
}

?>