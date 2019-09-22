<?php

namespace App\Controllers;

use App\Models\Subscription;
use App\Models\User;
use App\Models\Payment;
use App\Helpers\AuthHelper;
use App\Helpers\UtilsHelper;
use App\Helpers\View;

require_once dirname(__FILE__).'/../../lib/PagSeguroLibrary/PagSeguroLibrary.php';

class PaymentController {
    public function index ($request, $response, $args)
    {
        AuthHelper::restrictToPermission(User::USER_LEVEL_ADMIN);
        $user = AuthHelper::getAuthenticatedUser();
        
        $users = User::findAll();
        $payments = Payment::findAll();

        $data = compact('user', 'users', 'payments');
        
        View::render('layout/header', $data);
        View::render('payment/index', $data);
        View::render('layout/footer', $data);
        return $response;
    }

    public function store ($request, $response, $args)
    {
        AuthHelper::restrictToPermission(User::USER_LEVEL_ADMIN);
        $user = AuthHelper::getAuthenticatedUser();

        $payment = new Payment();
        $payment->setAttr('amount', $_POST['amount']);
        $payment->setAttr('status', Payment::PAYMENT_CONFIRMED);
        $payment->setAttr('date', time());
        $payment->setAttr('comment', $_POST['comment']);
        $payment->setAttr('fk_user', $_POST['fk_user']);
        $payment->save();
        
        // if ($aData['createdOrUpdated']) {
        //     $user 	= User::getById($_REQUEST['fk_user']);
        //     $aHeaders = 'From: sac@cc.uffs.edu.br' . "\r\n" . 'Reply-To: cacomputacaouffs@gmail.com';
        //     mail($user->email, 'Pagamento validado - Semana Academica CC UFFS', "Olá\n\nSeu pagamento de R$ ".sprintf('%.2f', $_REQUEST['amount'])." foi validado pela organização.\n\nAtenciosamente,\nOrganização 3ª Semana Acadêmica da Computaçao - UFFS");
        // }

        return $response
            ->withHeader('Location', UtilsHelper::base_url("/admin/pagamento"))
            ->withStatus(302);
    }

    public function delete ($request, $response, $args) {
        AuthHelper::restrictToPermission(User::USER_LEVEL_ADMIN);
        $payment = Payment::findById($args['id']);
        $payment->delete();
        return $response
            ->withHeader('Location', UtilsHelper::base_url("/admin/pagamento"))
            ->withStatus(302);  
    }

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
}