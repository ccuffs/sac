<?php 
require_once dirname(__FILE__).'/inc/globals.php';

authAllowAuthenticated();

$aUser 		= authGetAuthenticatedUserInfo();
$aMustPay 	= attendingCalculateUserDept($aUser['id']) + CONFERENCE_PRICE;
$aCredit 	= paymentCalculateUserCredit($aUser['id']);
$aDebit		= $aMustPay - $aCredit;

$aData						= array();
$aData['dept'] 				= $aDebit;
$aData['payments'] 			= paymentFindByUser($aUser['id']);
$aData['showPayButton']		= $aDebit > 0;
$aData['noDept']			= $aDebit <= 0;

$aPaymentIsBeingAnalyzed = false;

foreach($aData['payments'] as $aId => $aPayment) {
	if (paymentIsBeingAnalyzed($aPayment)) {
		$aPaymentIsBeingAnalyzed = true;
		break;
	}
}

$aData['beingAnalyzed'] = $aPaymentIsBeingAnalyzed;

View::render('ajax-payments', $aData);

?>