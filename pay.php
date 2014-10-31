<?php 
	require_once dirname(__FILE__).'/inc/globals.php';
	require_once dirname(__FILE__).'/inc/3rdparty/PagSeguroLibrary/PagSeguroLibrary.php';
	
	authAllowAuthenticated();
	
	$aUser 		= authGetAuthenticatedUserInfo();
	$aUser 		= userGetById($aUser['id']);
	
	$aMustPay 	= attendingCalculateUserDept($aUser['id']) + CONFERENCE_PRICE;
	$aCredit 	= paymentCalculateUserCredit($aUser['id']);
	$aDebit		= $aMustPay - $aCredit;
	
	if ($aDebit < 0) {
		echo 'Você não precisa pagar porque possui créditos!';
		exit();
	}
	
	$aRef = paymentCreate($aUser['id'], $aDebit);
	
	if ($aRef === false) {
		echo 'Problema na criação do pagamento.';
		exit();
	}
	
	 // Instantiate a new payment request
	$paymentRequest = new PagSeguroPaymentRequest();

	// Set the currency
	$paymentRequest->setCurrency("BRL");

	// Add an item for this payment request
	$aProduto = @$_REQUEST['id'] == 2 ? 'Inscrição de Time - Campeonato CS:GO' : 'Inscrição Semana Academica Computacao (2014) - UFFS';
	$paymentRequest->addItem('0001', $aProduto, 1, $aDebit);

	// Set a reference code for this payment request. It is useful to identify this payment
	// in future notifications.
	$paymentRequest->setReference($aRef);

	// Set shipping information for this payment request
	$sedexCode = PagSeguroShippingType::getCodeByType('SEDEX');
	$paymentRequest->setShippingType($sedexCode);
	$paymentRequest->setShippingAddress(
		'89801001',
		'Rod. SC 459 Km 02, Campus UFFS',
		'S/N',
		'',
		'',
		'Chapeco',
		'SC',
		'BRA'
	);

	// Set your customer information.
	$paymentRequest->setSender(
		$aUser['name'],
		$aUser['email'],
		'',
		'',
		'CPF',
		''
	);

	// Set the url used by PagSeguro to redirect user after checkout process ends
	$paymentRequest->setRedirectUrl("http://cc.uffs.edu.br/sac/");

	try {

		/*
		 * #### Credentials #####
		 * Replace the parameters below with your credentials (e-mail and token)
		 * You can also get your credentials from a config file. See an example:
		 * $credentials = PagSeguroConfig::getAccountCredentials();
		 */
		$credentials = new PagSeguroAccountCredentials(PAGSEGURO_EMAIL, PAGSEGURO_TOKEN);

		// Register this payment request in PagSeguro to obtain the payment URL to redirect your customer.
		$url = $paymentRequest->register($credentials);
		
		header('Location: ' . $url);
		exit();
		
	} catch (PagSeguroServiceException $e) {
		die($e->getMessage());
	}
?>