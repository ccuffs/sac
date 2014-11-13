<?php 
	require_once dirname(__FILE__).'/inc/globals.php';

	authAllowAuthenticated();
	
	$aData			= array();
	$aUser 			= userGetById($_SESSION['user']['id']);
	$aIsAdmin 		= userIsLevel($aUser, USER_LEVEL_ADMIN);
	
	if (!$aIsAdmin) {
		header("Location: restricted.php");
		exit();
	}
	
	$aUsers 						= userFindAll();
	$aPaidCredit					= paymentFindUsersWithPaidCredit();
	
	$aData['total_paid']			= 0;					
	$aData['users_paid_total'] 		= 0;
	$aData['users_nonpaid_total'] 	= 0;
	$aData['users_insiders']		= 0;
	$aData['users_outsiders']		= 0;
	$aData['users_total']			= count($aUsers);
	
	foreach($aUsers as $aId => $aInfo) {
		$aUsers[$aId]['paid'] 			= isset($aPaidCredit[$aId]) && $aPaidCredit[$aId] >= userGetConferencePrice($aInfo);
		$aUsers[$aId]['paid_credit'] 	= isset($aPaidCredit[$aId]) ? $aPaidCredit[$aId] : 0;
		$aUsers[$aId]['admin'] 			= $aInfo['type'] == USER_LEVEL_ADMIN;
		
		if ($aInfo['type'] == USER_LEVEL_UFFS || $aInfo['type'] == USER_LEVEL_ADMIN) {
			$aUsers[$aId]['source'] = 'UFFS';
			$aData['users_insiders']++;
			
		} else {
			$aUsers[$aId]['source'] = 'Externo';
			$aData['users_outsiders']++;
		}
		
		if ($aUsers[$aId]['paid']) {
			$aData['users_paid_total']++;

		} else {
			$aData['users_nonpaid_total']++;
		}
		
		$aData['total_paid'] += (float)$aUsers[$aId]['paid_credit'];
	}
	
	$aData['users'] = $aUsers;
	
	View::render('registrations', $aData);
?>