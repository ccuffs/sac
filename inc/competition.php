<?php

require_once dirname(__FILE__).'/config.php';


function competitionGetById($theId) {
	global $gDb;
	
	$aRet = null;
	$aQuery = $gDb->prepare("SELECT * FROM competition WHERE id = ?");
	
	if ($aQuery->execute(array($theId))) {
		$aRet = $aQuery->fetch();
	}
	
	return $aRet;
}

function competitionFindTeams($theCompetitionId) {
	global $gDb;
	
	$aRet = array();
	$aQuery = $gDb->prepare("SELECT * FROM teams WHERE fk_competition = ?");
	
	if ($aQuery->execute(array($theCompetitionId))) {
		while ($aRow = $aQuery->fetch()) {
			$aRet[$aRow['id']] = $aRow;
		}
	}
	
	return $aRet;
}

function competitionFindTeamByLeaderId($theCompetitionId, $theLeaderId) {
	global $gDb;
	
	$aRet = null;
	$aQuery = $gDb->prepare("SELECT * FROM teams WHERE fk_competition = ? AND fk_leader = ?");
	
	if ($aQuery->execute(array($theCompetitionId, $theLeaderId))) {
		$aRet = $aQuery->fetch();
	}
	
	return $aRet;
}

function competitionUpdateOrCreateTeam($theCompetitionId, $theTeamId, $theTeamInfo) {
	global $gDb;
	
	$aRet 	= false;
	$aQuery = $gDb->prepare("INSERT INTO teams (id, fk_leader, fk_competition, name, members, url) VALUES (".(is_numeric($theTeamId) ? '?' : 'NULL').", ?, ?, ?, ?, ?)
							ON DUPLICATE KEY UPDATE fk_leader = ?, fk_competition = ?, name = ?, members = ?, url = ?");
	
	$aPlaceholders = array();
	
	if (is_numeric($theTeamId)) {
		$aPlaceholders[] = $theTeamId;
	}
	
	$aPlaceholders[] = $theTeamInfo['fk_leader'];
	$aPlaceholders[] = $theCompetitionId;
	$aPlaceholders[] = $theTeamInfo['name'];
	$aPlaceholders[] = $theTeamInfo['members'];
	$aPlaceholders[] = $theTeamInfo['url'];
	
	$aPlaceholders[] = $theTeamInfo['fk_leader'];
	$aPlaceholders[] = $theCompetitionId;
	$aPlaceholders[] = $theTeamInfo['name'];
	$aPlaceholders[] = $theTeamInfo['members'];
	$aPlaceholders[] = $theTeamInfo['url'];
	
	$aRet = $aQuery->execute($aPlaceholders);
	return $aRet;
}

?>