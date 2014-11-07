<?php

require_once dirname(__FILE__).'/config.php';

define('USER_LEVEL_UFFS', 		1);
define('USER_LEVEL_EXTERNAL', 	2);
define('USER_LEVEL_ADMIN', 		3);

function userGetById($theUserId) {
	global $gDb;
	
	$aUser = null;
	$aQuery = $gDb->prepare("SELECT id, login, name, email, type FROM users WHERE id = ?");
	
	if ($aQuery->execute(array($theUserId))) {	
		$aUser = $aQuery->fetch();
	}
	
	return $aUser;
}

function userFindByIds($theUserIds) {
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

function userFindAll() {
	global $gDb;
	
	$aRet = array();
	$aQuery = $gDb->prepare("SELECT id, login, name, email, type FROM users WHERE 1");
	
	if ($aQuery->execute()) {	
		while ($aRow = $aQuery->fetch()) {
			$aRet[$aRow['id']] = $aRow;
		}
	}
	
	return $aRet;
}

function userIsLevel($theUserInfo, $theLevel) {
	return $theUserInfo['type'] == $theLevel;
}

function userLoginfyName($theName) {
	$aParts = explode(' ', strtolower($theName));
	$aName  = '';
	
	for ($i = 0; $i < count($aParts) - 1; $i++) {
		$aName .= strlen($aParts[$i]) >= 1 ? $aParts[$i][0] : '';
	}
	
	$aName .= $aParts[$i];
	return $aName;
}

?>