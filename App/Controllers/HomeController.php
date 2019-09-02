<?php

namespace App\Controllers;

use App\Models\Event;
use App\Models\User;
use App\Models\Subscription;

class HomeController {
    public function home ($request, $response, $args) {
        $authenticated = authIsAuthenticated();
        $data = array();
        $user = $authenticated ? authGetAuthenticatedUserInfo() : null;
        
        $data['events'] = array();
        $events = Event::findAll();
        
        foreach($events as $id => $info) {
            $date = $info['day'] . ' de ' . utilMonthToString($info['month']) . ' ('.utilWeekDayToString($info['day'], $info['month']).')';
            
            if (!isset($data['events'][$date])) {
                $data['events'][$date] = array();
            }
            
            $data['events'][$date][$id] = $info;
        }
        
        if ($authenticated) {
            $data['attending']	= Subscription::findByUserId($user->id);
        }

        $data['authenticated'] = $authenticated;
        $data['isAdmin'] = false;

        if ($user) {
            $data['isAdmin'] = $user->isLevel(User::USER_LEVEL_ADMIN);
        }
        
        \core\View::render('index', $data);
        return $response;
    }
}