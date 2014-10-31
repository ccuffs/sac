<?php 
	require_once dirname(__FILE__).'/inc/globals.php';
	require_once dirname(__FILE__).'/inc/3rdparty/PagSeguroLibrary/PagSeguroLibrary.php';

	function transactionNotification($notificationCode) {
        /*
         * #### Credentials #####
         * Replace the parameters below with your credentials (e-mail and token)
         * You can also get your credentials from a config file. See an example:
         * $credentials = PagSeguroConfig::getAccountCredentials();
         */
        $credentials = new PagSeguroAccountCredentials(PAGSEGURO_EMAIL, PAGSEGURO_TOKEN);
		
        try {
            $transaction = PagSeguroNotificationService::checkTransaction($credentials, $notificationCode);
			$ref = $transaction->getReference();
			
			paymentUpdateStatus($ref, $transaction->getStatus()->getValue());
			
            // Do something with $transaction
        } catch (PagSeguroServiceException $e) {
		
            paymentLog($e->getMessage());
        }
    }
	
	$code = (isset($_POST['notificationCode']) && trim($_POST['notificationCode']) !== "" ?	trim($_POST['notificationCode']) : null);
	$type = (isset($_POST['notificationType']) && trim($_POST['notificationType']) !== "" ?	trim($_POST['notificationType']) : null);

	if ($code && $type) {
		$notificationType = new PagSeguroNotificationType($type);
		$strType = $notificationType->getTypeFromValue();

		switch ($strType) {
			case 'TRANSACTION':
				transactionNotification($code);
				break;

			default:
				paymentLog("Unknown notification type [" . $notificationType->getValue() . "] " . print_r($_POST, true));
		}

	} else {
		paymentLog('Invalid notification parameters. ' . print_r($_POST, true));
	}
	
	echo 'Lost anything? :)';
?>