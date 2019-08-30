<?php

namespace App\Controllers;

use \core\View;

class SubscribeController {
    public function index ($request, $response, $args)
    {
        authAllowAuthenticated();
	
        $aData			= array();
        $aUser 			= userGetById($_SESSION['user']['id']);
        $aIsAdmin 		= userIsLevel($aUser, USER_LEVEL_ADMIN);
        
        if (!$aIsAdmin) {
            View::render('restricted');
            return $response;
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
            $aUsers[$aId]['no_payment'] 	= !isset($aPaidCredit[$aId]);
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
        return $response;
    }

    public function payment ($request, $response, $args)
    {
        authAllowAuthenticated();
	
        $aData			= array();
        $aUser 			= userGetById($_SESSION['user']['id']);
        $aIsAdmin 		= userIsLevel($aUser, USER_LEVEL_ADMIN);
        
        if (!$aIsAdmin) {
            View::render('restricted');
            return $response;
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
        return $response;
    }

    public function paymentCreate ($request, $response, $args)
    {
        authAllowAuthenticated();
	
        $aData			= array();
        $aUser 			= userGetById($_SESSION['user']['id']);
        $aIsAdmin 		= userIsLevel($aUser, USER_LEVEL_ADMIN);
        
        if (!$aIsAdmin) {
            View::render('restricted');
            return $response;
        }
        
        $aData['createdOrUpdated'] 	= paymentCreate($_REQUEST['fk_user'], $_REQUEST['amount'], $_REQUEST['comment']);
        
        if ($aData['createdOrUpdated']) {
            $aUser 	= userGetById($_REQUEST['fk_user']);
            $aHeaders = 'From: sac@cc.uffs.edu.br' . "\r\n" . 'Reply-To: cacomputacaouffs@gmail.com';
            mail($aUser['email'], 'Pagamento validado - Semana Academica CC UFFS', "Olá\n\nSeu pagamento de R$ ".sprintf('%.2f', $_REQUEST['amount'])." foi validado pela organização.\n\nAtenciosamente,\nOrganização 3ª Semana Acadêmica da Computaçao - UFFS");
        }
        
        $aUsers = userFindAll();
        
        foreach($aUsers as $aId => $aInfo) {
            $aUsers[$aId]['admin'] = $aInfo['type'] == USER_LEVEL_ADMIN;
            $aUsers[$aId]['source'] = $aInfo['type'] == USER_LEVEL_UFFS || $aInfo['type'] == USER_LEVEL_ADMIN ? 'UFFS' : 'Externo';
        }
        $aData['users'] = $aUsers;
        $aData['payments'] = paymentFindAll();
        
        View::render('payment-manager', $aData);
        return $response;
    }
}