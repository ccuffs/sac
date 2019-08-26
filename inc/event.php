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

function eventDelete($theId) {
	global $gDb;
	
	$aQuery = $gDb->prepare("DELETE FROM event WHERE id = ?");
	return $aQuery->execute(array($theId));
}

function eventFindAll() {
	global $gDb;
	
	$aRet = array();
	$aQuery = $gDb->prepare("SELECT * FROM event WHERE 1 ORDER BY day ASC, month ASC, time ASC");
	
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

	$ghost = $theEventInfo['ghost'] == 1;

	/* I'm interpolating ghost in the sql because for some reason when I bindParam it I got and error  */

	$sql = "INSERT INTO event (id , fk_competition , day , month , time , title , description , place , price , capacity , waiting_capacity , ghost) VALUES
		 					  (:id, :fk_competition, :day, :month, :time, :title, :description, :place, :price, :capacity, :waiting_capacity, $ghost)
		ON DUPLICATE KEY UPDATE
		fk_competition = :fk_competition, day = :day, month = :month, time = :time, title = :title, description = :description, place = :place, price = :price, capacity = :capacity, waiting_capacity = :waiting_capacity, ghost = $ghost";
	$aQuery = $gDb->prepare($sql);

	$id = is_numeric($theId) ? $theId : null;
	$fk_competition = $theEventInfo['fk_competition'] ? $theEventInfo['fk_competition'] : null;
	
	$aQuery->bindParam('fk_competition', $fk_competition);
	$aQuery->bindParam('id', $id);
	$aQuery->bindParam('day', $theEventInfo['day']);
	$aQuery->bindParam('month', $theEventInfo['month']);
	$aQuery->bindParam('time', $theEventInfo['time']);
	$aQuery->bindParam('title', $theEventInfo['title']);
	$aQuery->bindParam('description', $theEventInfo['description']);
	$aQuery->bindParam('place', $theEventInfo['place']);
	$aQuery->bindParam('price', $theEventInfo['price']);
	$aQuery->bindParam('capacity', $theEventInfo['capacity']);
	$aQuery->bindParam('waiting_capacity', $theEventInfo['waiting_capacity']);
	$aQuery->bindParam('ghost', $ghost);
	
	$aRet = $aQuery->execute();
	return $aRet;
}

?>