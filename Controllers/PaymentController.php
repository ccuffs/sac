<?php

namespace Controllers;

class PaymentController {
    public function apiIndex ($request, $response, $args)
    {
        authAllowAuthenticated();

        $aUser 		= authGetAuthenticatedUserInfo();
        $aMustPay 	= attendingCalculateUserDept($aUser);
        $aCredit 	= paymentCalculateUserCredit($aUser['id']);
        $aDebit		= $aMustPay - $aCredit;

        $aData						= array();
        $aData['dept'] 				= $aDebit;
        $aData['payments'] 			= paymentFindByUser($aUser['id']);
        $aData['showPayButton']		= $aDebit > 0;
        $aData['noDept']			= $aDebit <= 0;

        $aPaymentIsBeingAnalyzed = true;

        foreach($aData['payments'] as $aId => $aPayment) {
            $aPaymentIsBeingAnalyzed = false;
        }

        $aData['beingAnalyzed'] = $aPaymentIsBeingAnalyzed;

        \core\View::render('ajax-payments', $aData);
        return $response;
    }
}