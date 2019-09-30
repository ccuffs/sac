<?php

namespace App\Controllers;

use App\Models\Subscription;
use App\Models\User;
use App\Models\Event;
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
        $events = Event::findPriceds();

        $data = compact('user', 'events', 'users', 'payments');
        
        View::render('layout/admin/header', $data);
        View::render('payment/index', $data);
        View::render('layout/admin/footer', $data);
        return $response;
    }

    public function stats ($request, $response, $args) {
        AuthHelper::restrictToPermission(User::USER_LEVEL_ADMIN);
        $user = AuthHelper::getAuthenticatedUser();	

        $users = User::findAll();
        $total_paid = Payment::getTotalPaid();			
        $users_paid_total = count(User::findPaying());
        $users_nonpaid_total = count(User::findNonPaying());
        $users_insiders = count(User::findInsiders());
        $users_outsiders = count(User::findOutsiders());
        $users_total = count($users);
        
        $data = compact('user', 'users', 'total_paid', 'users_paid_total', 'users_nonpaid_total', 'users_insiders', 'users_outsiders', 'users_total');
        
        View::render('layout/admin/header', $data);
        View::render('payment/stats', $data);
        View::render('layout/admin/footer', $data);
        return $response;
    }

    public function store ($request, $response, $args)
    {
        AuthHelper::restrictToPermission(User::USER_LEVEL_ADMIN);
        $user = AuthHelper::getAuthenticatedUser();

        $payment = new Payment();
        $payment->setAttr('amount', str_replace(',','.',@$_POST['amount']));
        $payment->setAttr('cpf', @$_POST['cpf']);
        $payment->setAttr('status', Payment::PAYMENT_CONFIRMED);
        $payment->setAttr('date', time());
        $payment->setAttr('comment', @$_POST['comment']);
        $payment->setAttr('fk_user', @$_POST['fk_user']);
        $payment->setAttr('type', @$_POST['type']);
        $payment->setAttr('fk_event', @$_POST['fk_event']);
        $payment->save();

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