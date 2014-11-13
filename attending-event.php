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
	
	$aEvent			= eventGetById($aId);
	$aUsers 		= array();
	$aAttending 	= array();
	$aPaidCredit	= paymentFindUsersWithPaidCredit();	
	$aEmailsPaid	= array();
	$aEmailsNonPaid	= array();
	
	if($aEvent != null) {
		if (isset($_REQUEST['remove'])) {
			$aData['createdOrUpdated'] = attendingRemove($_REQUEST['remove'], $aEvent['id']);
		}
		
		$aAttending = attendingFindUsersByEventId($aId);
		$aUsers = userFindByIds(array_keys($aAttending));
	}

	foreach($aUsers as $aId => $aInfo) {
		$aUsers[$aId]['admin'] 	= $aInfo['type'] == USER_LEVEL_ADMIN;
		$aUsers[$aId]['source'] = $aInfo['type'] == USER_LEVEL_UFFS || $aInfo['type'] == USER_LEVEL_ADMIN ? 'UFFS' : 'Externo';
		$aUsers[$aId]['paid'] 	= isset($aPaidCredit[$aId]) && $aPaidCredit[$aId] >= userGetConferencePrice($aInfo);
		
		if ($aUsers[$aId]['paid']) {
			$aEmailsPaid[] = $aInfo['email'];
		} else {
			$aEmailsNonPaid[] = $aInfo['email'];
		}
	}
	
	$aData['users'] 		= $aUsers;
	$aData['event'] 		= $aEvent;
	$aData['attending'] 	= $aAttending;
	$aData['emailsPaid'] 	= $aEmailsPaid;
	$aData['emailsNonPaid'] = $aEmailsNonPaid;
	
	View::render('attending-event', $aData);
?>