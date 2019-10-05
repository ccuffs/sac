<?php

namespace App\Controllers;

use App\Helpers\AuthHelper;
use App\Models\User;
use App\Models\Event;
use App\Helpers\View;

class SpeakerController {

    private $responseMessage = array();

    public function index($request, $response, $args) {
        
        $user = AuthHelper::getAuthenticatedUser();

        $data = compact('user');

        View::render('layout/header', $data);
        View::render('speakers/index');
        View::render('layout/footer');

        return $response;
    }
    
    public function create($request, $response, $args) {
        
        $user = AuthHelper::getAuthenticatedUser();

        $events = Event::findAll();

        $data = compact('user', 'events');

        View::render('layout/header', $data);
        View::render('speakers/create', $data);
        View::render('layout/footer');

        return $response;
    }

    public function store($request, $response, $args) {

        AuthHelper::restrictToPermission(User::USER_CO_ORGANIZER);

        $speaker = new Speakers();
        $body = $request->getParsedBody();
        $speaker->setAttr('name', $body['name']);
        $speaker->setAttr('description', $body['description']);
        $speaker->setAttr('fk_event', $body['event']);
        $id = $speaker->save();

        if (!$id) {
            return $response
                ->withHeader('Location', UtilsHelper::base_url("/admin/campeonato/create"))
                ->withStatus(302);   
        }

        return $response
            ->withHeader('Location', UtilsHelper::base_url("/admin/campeonato/$id"))
            ->withStatus(302);

        return $response;
        
    }



}

