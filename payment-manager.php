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
	
	if (isset($_POST['hasValue'])) {
		$aData['createdOrUpdated'] 	= paymentCreate($_REQUEST['fk_user'], $_REQUEST['amount'], $_REQUEST['comment']);
		
		if ($aData['createdOrUpdated']) {
			$aUser 	= userGetById($_REQUEST['fk_user']);
			$aHeaders = 'From: sac@cc.uffs.edu.br' . "\r\n" . 'Reply-To: cacomputacaouffs@gmail.com';
			mail($aUser['email'], 'Pagamento validado - Semana Academica CC UFFS', "Olá\n\nSeu pagamento de R$ ".sprintf('%.2f', $_REQUEST['amount'])." foi validado pela organização.\n\nAtenciosamente,\nOrganização 3ª Semana Acadêmica da Computaçao - UFFS");
		}
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