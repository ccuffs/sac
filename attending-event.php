<?php 
	require_once dirname(__FILE__).'/inc/globals.php';
	
	authAllowAuthenticated();
	
	$aData			= array();
	$aId			= isset($_REQUEST['id']) ? $_REQUEST['id'] : 0;
	$aUser 			= userGetById($_SESSION['user']['id']);
	$aIsAdmin 		= userIsLevel($aUser, USER_LEVEL_ADMIN);
	
	if (!$aIsAdmin) {
		header("Location: restricted.php");
		exit();
	}
	
	$aEvent		= eventGetById($_REQUEST['id']);
	$aUsers 	= array();
	$aAttending = array();
	
	if($aEvent != null) {
		$aAttending = attendingFindUsersByEventId($aId);
		$aUsers = userFindByIds(array_keys($aAttending));
	}

	foreach($aUsers as $aId => $aInfo) {
		$aUsers[$aId]['admin'] = $aInfo['type'] == USER_LEVEL_ADMIN;
		$aUsers[$aId]['source'] = $aInfo['type'] == USER_LEVEL_UFFS || $aInfo['type'] == USER_LEVEL_ADMIN ? 'UFFS' : 'Externo';
	}
	
	$aData['users'] 		= $aUsers;
	$aData['event'] 		= $aEvent;
	$aData['attending'] 	= $aAttending;
	
	View::render('attending-event', $aData);
?>