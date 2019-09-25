<?php

namespace App\Controllers;

use App\Helpers\View;
use App\Models\User;
use App\Models\Payment;
use App\Helpers\AuthHelper;

class SubscribeController {
    public function index ($request, $response, $args)
    {
        AuthHelper::allowAuthenticated();
	
        $aData			= array();
        $user 			= User::getById($_SESSION['user']);
        $aIsAdmin 		= $user->isLevel(User::USER_LEVEL_ADMIN);
        
        if (!$aIsAdmin) {
            View::render('restricted');
            return $response;
        }
        
        $users 						= User::findAll();
        $aPaidCredit				= Payment::findUsersWithPaidCredit();
        
        $aData['total_paid']			= 0;					
        $aData['users_paid_total'] 		= 0;
        $aData['users_nonpaid_total'] 	= 0;
        $aData['users_insiders']		= 0;
        $aData['users_outsiders']		= 0;
        $aData['users_total']			= count($users);

        foreach($users as $aId => $aInfo) {
            $users[$aId]['no_payment'] 	= !isset($aPaidCredit[$aId]);
            $users[$aId]['paid'] 			= isset($aPaidCredit[$aId]) && $aPaidCredit[$aId] >= $user->getConferencePrice($aInfo);
            $users[$aId]['paid_credit'] 	= isset($aPaidCredit[$aId]) ? $aPaidCredit[$aId] : 0;
            $users[$aId]['admin'] 			= $aInfo['type'] == User::USER_LEVEL_ADMIN;
            
            if ($aInfo['type'] == User::USER_LEVEL_UFFS || $aInfo['type'] == User::USER_LEVEL_ADMIN) {
                $users[$aId]['source'] = 'UFFS';
                $aData['users_insiders']++;
                
            } else {
                $users[$aId]['source'] = 'Externo';
                $aData['users_outsiders']++;
            }
            
            if ($users[$aId]['paid']) {
                $aData['users_paid_total']++;

            } else {
                $aData['users_nonpaid_total']++;
            }
            
            $aData['total_paid'] += (float)$users[$aId]['paid_credit'];
        }
        
        $aData['users'] = $users;
        
        View::render('registrations', $aData);
        return $response;
    }
}