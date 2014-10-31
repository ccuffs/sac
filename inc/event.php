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

?>