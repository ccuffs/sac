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
        $user = $authenticated ? AuthHelper::getAuthenticatedUserInfo() : null;
        
        $data['events'] = array();
        $events = Event::findAll();
        
        foreach($events as $id => $info) {
            $date = $info['day'] . ' de ' . UtilsHelper::monthToString($info['month']) . ' ('.UtilsHelper::weekDayToString($info['day'], $info['month']).')';
            
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
        
        \App\Helpers\View::render('index', $data);
        return $response;
    }
}