<?php

namespace App\Controllers;

use App\Models\Event;
use App\Models\User;
use App\Models\Speaker;
use App\Models\Subscription;
use App\Helpers\AuthHelper;
use App\Helpers\UtilsHelper;
use App\Helpers\View;

class HomeController {
    public function home ($request, $response, $args) {
        $authenticated = AuthHelper::isAuthenticated();
        $data = array();
        $user = AuthHelper::getAuthenticatedUser();
        
        $events = Event::findAll();
        $speakers = Speaker::findAll();

        $day_programming = [];
        
        foreach($events as $id => $event) {
            $date = $event->day . ' de ' . UtilsHelper::monthToString($event->month) . ' ('.UtilsHelper::weekDayToString($event->day, $event->month).')';
            
            if (!isset($day_programming[$date])) {
                $day_programming[$date] = array();
            }
            
            $day_programming[$date][$id] = $event;
        }
        
        if ($authenticated) {
            $data['attending']	= Subscription::findByUserId($user->id);
        }

        $data = compact('user', 'day_programming', 'events', 'speakers');
        
        View::render('layout/website/header', $data);
        View::render('home', $data);
        View::render('layout/website/footer', $data);
        return $response;
    }

    public function dashboard ($request, $response, $args) {
        AuthHelper::restrictToPermission(User::USER_LEVEL_ADMIN);
        $user = AuthHelper::getAuthenticatedUser();
        
        $data = compact(['user']);
        View::render('layout/admin/header', $data);
        View::render('dashboard', $data);
        View::render('layout/admin/footer', $data);
        return $response;
    }
}