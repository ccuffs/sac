<?php

namespace App\Controllers;

use App\Models\Subscription;
use App\Models\Payment;
use App\Helpers\AuthHelper;

require_once dirname(__FILE__).'/../../lib/PagSeguroLibrary/PagSeguroLibrary.php';

class PaymentController {
    public function apiIndex ($request, $response, $args)
    {
        AuthHelper::AllowAuthenticated();

        $aUser 		= AuthHelper::getAuthenticatedUser();
        $aMustPay 	= Payment::calculateUserDept($aUser);
        $aCredit 	= Payment::calculateUserCredit($aUser->id);
        $aDebit		= $aMustPay - $aCredit;

        $aData						= array();
        $aData['dept'] 				= $aDebit;
        $aData['payments'] 			= Payment::findByUser($aUser->id);
        $aData['showPayButton']		= $aDebit > 0;
        $aData['noDept']			= $aDebit <= 0;

        $aPaymentIsBeingAnalyzed = true;

        foreach($aData['payments'] as $aId => $aPayment) {
            $aPaymentIsBeingAnalyzed = false;
        }

        $aData['beingAnalyzed'] = $aPaymentIsBeingAnalyzed;

        \App\Helpers\View::render('ajax-payments', $aData);
        return $response;
    }

    /* TODO: test this function */
    public function execute ()
    {
        AuthHelper::AllowAuthenticated();
        
        $aUser 		= AuthHelper::getAuthenticatedUser();
        $aUser 		= userGetById($aUser['id']);
        
        $aMustPay 	= Payment::calculateUserDept($aUser['id']) + CONFERENCE_PRICE;
        $aCredit 	= Payment::calculateUserCredit($aUser['id']);
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
    }

    /* TODO: test this function */
    public function pagseguro ()
    {
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
                
                paymentLog('Updating ref=' . $ref . ' to ' . $transaction->getStatus()->getValue());
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
    }
}