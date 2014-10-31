<?php

require_once dirname(__FILE__).'/config.php';

function eventGetById($theId) {
	global $gDb;
	
	$aRet = null;
	$aQuery = $gDb->prepare("SELECT * FROM event WHERE id = ?");
	
	if ($aQuery->execute(array($theId))) {
		$aRet = $aQuery->fetch();
	}
	
	return $aRet;
}

function eventFindAll() {
	global $gDb;
	
	$aRet = array();
	$aQuery = $gDb->prepare("SELECT * FROM event WHERE 1 ORDER BY day ASC, month ASC");
	
	if ($aQuery->execute()) {
		while ($aRow = $aQuery->fetch()) {
			$aRet[$aRow['id']] = $aRow;
		}
	}
	
	return $aRet;
}

function eventFindByUserIsAttending($theUserId) {
	global $gDb;
	
	$aRet = array();
	$aQuery = $gDb->prepare("SELECT * FROM event WHERE id IN (SELECT fk_event FROM attending WHERE fk_user = ?)");
	
	if ($aQuery->execute(array($theUserId))) {
		while ($aRow = $aQuery->fetch()) {
			$aRet[$aRow['id']] = $aRow;
		}
	}
	
	return $aRet;
}

function eventUpdateOrCreate($theId, $theEventInfo) {
	global $gDb;
	
	$aRet 	= false;
	$aQuery = $gDb->prepare("INSERT INTO event (id, fk_competition, day, month, time, title, description, place, price, capacity, waiting_capacity, ghost) VALUES
											   (".(is_numeric($theId) ? '?' : 'NULL').", ".(is_numeric($theEventInfo['fk_competition']) ? '?' : 'NULL').", ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
							ON DUPLICATE KEY UPDATE
											   fk_competition = ".(is_numeric($theEventInfo['fk_competition']) ? '?' : 'NULL').", day = ?, month = ?, time = ?, title = ?, description = ?, place = ?, price = ?, capacity = ?, waiting_capacity = ?, ghost = ?");
	
	$aPlaceholders = array();
	
	if (is_numeric($theId)) 							{ $aPlaceholders[] = $theId; }
	if (is_numeric($theEventInfo['fk_competition'])) 	{ $aPlaceholders[] = $theEventInfo['fk_competition']; }
	
	$aPlaceholders[] = $theEventInfo['day'];
	$aPlaceholders[] = $theEventInfo['month'];
	$aPlaceholders[] = $theEventInfo['time'];
	$aPlaceholders[] = $theEventInfo['title'];
	$aPlaceholders[] = $theEventInfo['description'];
	$aPlaceholders[] = $theEventInfo['place'];
	$aPlaceholders[] = $theEventInfo['price'];
	$aPlaceholders[] = $theEventInfo['capacity'];
	$aPlaceholders[] = $theEventInfo['waiting_capacity'];
	$aPlaceholders[] = $theEventInfo['ghost'];
	
	if (is_numeric($theEventInfo['fk_competition'])) 	{ $aPlaceholders[] = $theEventInfo['fk_competition']; }

	$aPlaceholders[] = $theEventInfo['day'];
	$aPlaceholders[] = $theEventInfo['month'];
	$aPlaceholders[] = $theEventInfo['time'];
	$aPlaceholders[] = $theEventInfo['title'];
	$aPlaceholders[] = $theEventInfo['description'];
	$aPlaceholders[] = $theEventInfo['place'];
	$aPlaceholders[] = $theEventInfo['price'];
	$aPlaceholders[] = $theEventInfo['capacity'];
	$aPlaceholders[] = $theEventInfo['waiting_capacity'];	
	$aPlaceholders[] = $theEventInfo['ghost'];	
	
	$aRet = $aQuery->execute($aPlaceholders);
	return $aRet;
}

?>