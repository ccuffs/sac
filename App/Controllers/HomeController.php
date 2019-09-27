<?php

namespace App\Controllers;

use App\Models\Event;
use App\Models\User;
use App\Models\Subscription;
use App\Helpers\AuthHelper;
use App\Helpers\UtilsHelper;

class HomeController {
    public function home ($request, $response, $args) {
        $authenticated = AuthHelper::isAuthenticated();
        $data = array();
        $user = AuthHelper::getAuthenticatedUser();
        
        $data['events'] = array();
        $events = Event::findAll();
        
        foreach($events as $id => $event) {
            $date = $event->day . ' de ' . UtilsHelper::monthToString($event->month) . ' ('.UtilsHelper::weekDayToString($event->day, $event->month).')';
            
            if (!isset($data['events'][$date])) {
                $data['events'][$date] = array();
            }
            
            $data['events'][$date][$id] = $event;
        }
        
        if ($authenticated) {
            $data['attending']	= Subscription::findByUserId($user->id);
        }

        $data['authenticated'] = $authenticated;
        $data['isAdmin'] = false;

        if ($user) {
            $data['isAdmin'] = $user->isLevel(User::USER_LEVEL_ADMIN);
        }
        
        \App\Helpers\View::render('home', $data);
        return $response;
    }
}