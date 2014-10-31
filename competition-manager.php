<?php 
	require_once dirname(__FILE__).'/inc/globals.php';
	
	authAllowAuthenticated();
	
	$aData			= array();
	$aUser 			= userGetById($_SESSION['user']['id']);
	$aIsAdmin 		= userIsLevel($aUser, USER_LEVEL_ADMIN);
	$aCompetition 	= isset($_REQUEST['id']) ? $_REQUEST['id'] : 0;
	
	$aData['user'] = $aUser;
	
	if (!$aIsAdmin) {
		header("Location: restricted.php");
		exit();
	}
	
	if (isset($_POST['hasValue'])) {
		$aData['createdOrUpdated'] 	= competitionUpdateOrCreate($aCompetition, $_POST);
	}
	
	$aData['competition'] = competitionGetById($aCompetition);
	
	View::render('competition-manager', $aData);
?>