<?php 
	require_once dirname(__FILE__).'/inc/globals.php';
	
	authAllowAuthenticated();
	
	$aData			= array();
	$aUser 			= userGetById($_SESSION['user']['id']);
	$aIsAdmin 		= userIsLevel($aUser, USER_LEVEL_ADMIN);
	
	$aData['user'] = $aUser;
	
	if (!$aIsAdmin) {
		header("Location: restricted.php");
		exit();
	}
	
	if (isset($_POST['hasValue'])) {
		$aData['createdOrUpdated'] 	= paymentCreate($_REQUEST['fk_user'], $_REQUEST['amount'], $_REQUEST['comment']);
	}
	
	if (isset($_REQUEST['delete'])) {
		$aData['createdOrUpdated'] = paymentDelete($_REQUEST['delete']);
	}
	
	$aUsers = userFindAll();
	
	foreach($aUsers as $aId => $aInfo) {
		$aUsers[$aId]['admin'] = $aInfo['type'] == USER_LEVEL_ADMIN;
		$aUsers[$aId]['source'] = $aInfo['type'] == USER_LEVEL_UFFS || $aInfo['type'] == USER_LEVEL_ADMIN ? 'UFFS' : 'Externo';
	}
	
	$aData['users'] = $aUsers;
	$aData['payments'] = paymentFindAll();
	
	View::render('payment-manager', $aData);
?>