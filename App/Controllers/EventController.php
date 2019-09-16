<?php

namespace App\Controllers;

use App\Helpers\View;
use App\Models\User;
use App\Models\Event;
use App\Models\Competition;
use App\Models\Payment;
use App\Models\Subscription;
use App\Helpers\AuthHelper;

class EventController {
    public function index ($request, $response, $args) {
        $user = AuthHelper::getAuthenticatedUser();
        
        $data = [
            'title' => 'Evento',
            'user' => $user,
            'events' => Event::findAll()
        ];

        View::render('layout/header', $data);
        View::render('event/index', $data);
        View::render('layout/footer', $data);

        return $response;
    }
    public function  adminIndex ($request, $response, $args)
    {
        AuthHelper::allowAuthenticated();
	
        $aData		= [];
        $aUser 		= User::getById($_SESSION['user']);
        $isAdmin 	= $aUser->isLevel(User::USER_LEVEL_ADMIN);
        $aEventId 	= isset($_REQUEST['id']) ? $_REQUEST['id'] : 0;
        
        $aData['user'] = $aUser;
        $aData['event'] = [];
        
        if (!$isAdmin) {
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
        AuthHelper::allowAuthenticated();
	
        $user = User::getById($_SESSION['user']);
        $isAdmin = $user->isLevel(User::USER_LEVEL_ADMIN);
        $aEventId = isset($_REQUEST['id']) ? $_REQUEST['id'] : 0;
        
        if (!$isAdmin) {
            View::render('restricted');
            return $response;
        }
        
        $data = [];
        $data['user'] = $user;
        $data['event'] = [];

        $data['createdOrUpdated'] = Event::create($_POST);

        $data['competitions'] = Competition::findAll();

        View::render('event-manager', $data);
        return $response;
    }

    /* TODO: Implement this */
    public function attempt($request, $response, $args)
    {
        AuthHelper::allowAuthenticated();
	
        $data = [];
        $user = User::getById($_SESSION['user']);
        $isAdmin = $user->isLevel(User::USER_LEVEL_ADMIN);
        
        if (!$isAdmin) {
            header("Location: restricted.php");
            exit();
        }
        
        $event = Event::getById($args['id']);
        $users = [];
        $attending = [];
        $paidCredit = Payment::findUsersWithPaidCredit();	
        $emailsPaid = [];
        $emailsNonPaid = [];
        
        if($event) {
            if (isset($_REQUEST['remove'])) {
                $data['createdOrUpdated'] = attendingRemove($_REQUEST['remove'], $event['id']);
            }
            
            $attending = Subscription::findByUserId($args['id']);
            $users = userFindByIds(array_keys($attending));
        }

        foreach($users as $aId => $aInfo) {
            $users[$aId]['admin'] 	= $aInfo['type'] == User::USER_LEVEL_ADMIN;
            $users[$aId]['source'] = $aInfo['type'] == User::USER_LEVEL_UFFS || $aInfo['type'] == User::USER_LEVEL_ADMIN ? 'UFFS' : 'Externo';
            $users[$aId]['paid'] 	= isset($paidCredit[$aId]) && $paidCredit[$aId] >= userGetConferencePrice($aInfo);
            
            if ($users[$aId]['paid']) {
                $emailsPaid[] = $aInfo['email'];
            } else {
                $emailsNonPaid[] = $aInfo['email'];
            }
        }
        
        $data['users'] = $users;
        $data['event'] = $event;
        $data['attending'] = $attending;
        $data['emailsPaid'] = $emailsPaid;
        $data['emailsNonPaid'] = $emailsNonPaid;
        
        View::render('attending-event', $data);
    }
}