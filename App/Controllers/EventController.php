<?php

namespace App\Controllers;

use \core\View;
use App\Models\User;
use App\Models\Event;
use App\Models\Competition;

class EventController {
    public function  adminIndex ($request, $response, $args)
    {
        authAllowAuthenticated();
	
        $aData		= array();
        $aUser 		= User::getById($_SESSION['user']['id']);
        $aIsAdmin 	= $aUser->isLevel(User::USER_LEVEL_ADMIN);
        $aEventId 	= isset($_REQUEST['id']) ? $_REQUEST['id'] : 0;
        
        $aData['user'] = $aUser;
        $aData['event'] = array();
        
        if (!$aIsAdmin) {
            View::render('restricted');
            return $response;
        }

        if (isset($_REQUEST['delete'])) {
            $aData['createdOrUpdated'] = eventDelete($_REQUEST['delete']);
            
        } else {
            $aData['event'] = Event::getById($aEventId);	
        }
        
        $aData['competitions'] = Competition::findAll();

        View::render('event-manager', $aData);
        return $response;
    }

    public function create ($request, $response, $args)
    {
        authAllowAuthenticated();
	
        $aData		= array();
        $aUser 		= User::getById($_SESSION['user']['id']);
        $aIsAdmin 	= $aUser->isLevel(User::USER_LEVEL_ADMIN);
        $aEventId 	= isset($_REQUEST['id']) ? $_REQUEST['id'] : 0;
        
        if (!$aIsAdmin) {
            View::render('restricted');
            return $response;
        }

        $aData['user'] = $aUser;
        $aData['event'] = array();

        $aData['createdOrUpdated'] = Event::create($_POST);

        $aData['competitions'] = Competition::findAll();

        View::render('event-manager', $aData);
        return $response;
    }

    /* TODO: Implement this */
    public function attempt()
    {
        authAllowAuthenticated();
	
        $aData			= array();
        $aId			= isset($_REQUEST['id']) ? $_REQUEST['id'] : 0;
        $aUser 			= User::getById($_SESSION['user']['id']);
        $aIsAdmin 		= $aUser->isLevel(User::USER_LEVEL_ADMIN);
        
        if (!$aIsAdmin) {
            header("Location: restricted.php");
            exit();
        }
        
        $aEvent			= Event::getById($aId);
        $aUsers 		= array();
        $aAttending 	= array();
        $aPaidCredit	= paymentFindUsersWithPaidCredit();	
        $aEmailsPaid	= array();
        $aEmailsNonPaid	= array();
        
        if($aEvent != null) {
            if (isset($_REQUEST['remove'])) {
                $aData['createdOrUpdated'] = attendingRemove($_REQUEST['remove'], $aEvent['id']);
            }
            
            $aAttending = attendingFindUsersByEventId($aId);
            $aUsers = userFindByIds(array_keys($aAttending));
        }

        foreach($aUsers as $aId => $aInfo) {
            $aUsers[$aId]['admin'] 	= $aInfo['type'] == User::USER_LEVEL_ADMIN;
            $aUsers[$aId]['source'] = $aInfo['type'] == User::USER_LEVEL_UFFS || $aInfo['type'] == User::USER_LEVEL_ADMIN ? 'UFFS' : 'Externo';
            $aUsers[$aId]['paid'] 	= isset($aPaidCredit[$aId]) && $aPaidCredit[$aId] >= userGetConferencePrice($aInfo);
            
            if ($aUsers[$aId]['paid']) {
                $aEmailsPaid[] = $aInfo['email'];
            } else {
                $aEmailsNonPaid[] = $aInfo['email'];
            }
        }
        
        $aData['users'] 		= $aUsers;
        $aData['event'] 		= $aEvent;
        $aData['attending'] 	= $aAttending;
        $aData['emailsPaid'] 	= $aEmailsPaid;
        $aData['emailsNonPaid'] = $aEmailsNonPaid;
        
        View::render('attending-event', $aData);
    }
}