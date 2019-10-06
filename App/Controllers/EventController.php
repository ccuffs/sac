<?php

namespace App\Controllers;

use App\Helpers\View;
use App\Models\User;
use App\Models\Event;
use App\Models\Competition;
use App\Models\Payment;
use App\Models\Subscription;
use App\Helpers\AuthHelper;
use App\Helpers\UtilsHelper;

class EventController {
    public function index ($request, $response, $args) {
        AuthHelper::restrictToPermission(User::USER_LEVEL_ADMIN);
        $user = AuthHelper::getAuthenticatedUser();
        
        $data = [
            'title' => 'Evento',
            'user' => $user,
            'events' => Event::findAll()
        ];

        View::render('layout/admin/header', $data);
        View::render('event/index', $data);
        View::render('layout/admin/footer', $data);

        return $response;
    }

    public function show ($request, $response, $args) {
        AuthHelper::restrictToPermission(User::USER_LEVEL_ADMIN);
        $user = AuthHelper::getAuthenticatedUser();
        
        $event = Event::findById($args['id']);
        $title = 'Evento';

        $data = compact(['user', 'event', 'title']);

        View::render('layout/admin/header', $data);
        View::render('event/show', $data);
        View::render('layout/admin/footer', $data);

        return $response;
    }

    public function edit ($request, $response, $args) {
        AuthHelper::restrictToPermission(User::USER_LEVEL_ADMIN);
        $user = AuthHelper::getAuthenticatedUser();
        
        /* TODO: 404 if not exists */
        $event = Event::findById($args['id']);
        $competitions = Competition::findAll();

        $title = 'Evento';

        $data = compact(['user', 'event', 'competitions', 'title']);

        View::render('layout/admin/header', $data);
        View::render('event/edit', $data);
        View::render('layout/admin/footer', $data);

        return $response;
    }

    public function update ($request, $response, $args) {
        AuthHelper::restrictToPermission(User::USER_LEVEL_ADMIN);
        $event = Event::findById($args['id']);
        $body = $request->getParsedBody();
        $event->setAttr('title', $body['title']);
        $event->setAttr('description', $body['description']);
        $event->setAttr('day', $body['day']);
        $event->setAttr('time', $body['time']);
        $event->setAttr('month', $body['month']);
        $event->setAttr('place', $body['place']);
        $event->setAttr('ghost', $body['ghost']);
        $event->setAttr('price', UtilsHelper::format_money($body['price']));
        $event->setAttr('capacity', $body['capacity']);
        $event->setAttr('waitingCapacity', $body['waiting_capacity']);
        $event->setAttr('fk_competition', $body['fk_competition']);
        $event->save();

        return $response
            ->withHeader('Location', UtilsHelper::base_url("/admin/evento/".$args['id']))
            ->withStatus(302);      
    }

    public function delete ($request, $response, $args) {
        AuthHelper::restrictToPermission(User::USER_LEVEL_ADMIN);
        $event = Event::findById($args['id']);
        $event->delete();
        return $response
            ->withHeader('Location', UtilsHelper::base_url("/admin/evento"))
            ->withStatus(302);  
    }

    public function create ($request, $response, $args) {
        AuthHelper::restrictToPermission(User::USER_LEVEL_ADMIN);
        $user = AuthHelper::getAuthenticatedUser();
        $isAdmin = $user->isLevel(User::USER_LEVEL_ADMIN);
        
        if (!$isAdmin) {
            View::render('restricted');
            return $response;
        }
        
        $competitions = Competition::findAll();

        $title = 'Evento';

        $data = compact(['user', 'competitions', 'title']);

        View::render('layout/admin/header', $data);
        View::render('event/create', $data);
        View::render('layout/admin/footer', $data);
        return $response;
    }

    public function store ($request, $response, $args) {
        AuthHelper::restrictToPermission(User::USER_LEVEL_ADMIN);
        $event = new Event();
        $body = $request->getParsedBody();
        $event->setAttr('title', $body['title']);
        $event->setAttr('description', $body['description']);
        $event->setAttr('day', $body['day']);
        $event->setAttr('time', $body['time']);
        $event->setAttr('month', $body['month']);
        $event->setAttr('place', $body['place']);
        $event->setAttr('ghost', $body['ghost']);
        $event->setAttr('price', UtilsHelper::format_money($body['price'])); 
        $event->setAttr('capacity', $body['capacity']);
        $event->setAttr('waitingCapacity', $body['waiting_capacity']);
        $event->setAttr('fk_competition', $body['fk_competition']);
        $id = $event->save();

        if (!$id) {
            return $response
                ->withHeader('Location', UtilsHelper::base_url("/admin/evento/create"))
                ->withStatus(302);   
        }

        return $response
            ->withHeader('Location', UtilsHelper::base_url("/admin/evento/$id"))
            ->withStatus(302);   
    }
}