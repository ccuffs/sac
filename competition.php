<?php 
	require_once dirname(__FILE__).'/inc/globals.php';
	
	$aId 					= isset($_REQUEST['competition']) ? $_REQUEST['competition'] : 0;
	$aComptetition 			= competitionGetById($aId);
	$aAuthenticated 		= authIsAuthenticated();	
	$aTeam					= null;
	$aCompetitors			= null;
	$aUser					= null;
	
	if($aAuthenticated) {
		$aUser				= authGetAuthenticatedUserInfo();
		$aTeam				= competitionFindTeamByLeaderId($aId, $aUser['id']);
		$aCompetitors		= userFindAll();
	}
	
	if (isset($_REQUEST['register']) && $aComptetition != null && $aAuthenticated && $aUser != null) {
		$aTeamId = @$_REQUEST['id'];
		
		$aTeam['fk_leader'] = $aUser['id'];
		$aTeam['name']		= @$_POST['name'];
		$aTeam['members'] 	= serialize(array(@$_POST['member0'], @$_POST['member1'], @$_POST['member2'], @$_POST['member3'], @$_POST['member4']));
		$aTeam['url'] 		= @$_POST['url'];
		
		$aOk = competitionUpdateOrCreateTeam($aComptetition['id'], $aTeamId, $aTeam);
	}

	if($aTeam != null) {
		$aArray = @unserialize($aTeam['members']);
		$aTeam['members'] = $aArray === false ? array() : $aArray;
	}
	
	View::render('competition', array(
		'competition' 		=> $aComptetition,
		'teams' 			=> competitionFindTeams($aId),
		'team' 				=> $aTeam,
		'competitors' 		=> $aCompetitors,
		'authenticated'		=> $aAuthenticated,
	));
?>