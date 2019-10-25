<?php

namespace App\Controllers;

use App\Helpers\View;
use App\Models\User;
use App\Models\Competition;
use App\Helpers\AuthHelper;
use App\Helpers\UtilsHelper;

class CompetitionController {
    public function index ($request, $response, $args) {
        AuthHelper::restrictToPermission(User::USER_LEVEL_ADMIN);
        $user = AuthHelper::getAuthenticatedUser();
        
        $data = [
            'user' => $user,
            'events' => Competition::findAll()
        ];

        View::render('layout/admin/header', $data);
        View::render('competition/index', $data);
        View::render('layout/admin/footer', $data);

        return $response;
    }

    public function create ($request, $response, $args) {
        AuthHelper::restrictToPermission(User::USER_LEVEL_ADMIN);
        $user = AuthHelper::getAuthenticatedUser();
        
        $competitions = Competition::findAll();

        $title = 'Evento';

        $data = compact(['user', 'competitions', 'title']);

        View::render('layout/admin/header', $data);
        View::render('competition/create', $data);
        View::render('layout/admin/footer', $data);
        return $response;
    }

    public function store ($request, $response, $args) {
        AuthHelper::restrictToPermission(User::USER_LEVEL_ADMIN);
        $competition = new Competition();
        $body = $request->getParsedBody();
        $competition->setAttr('title', $body['title']);
        $competition->setAttr('description', $body['description']);
        $competition->setAttr('headline', $body['headline']);
        $competition->setAttr('prizes', $body['prizes']);
        $competition->setAttr('rules', $body['rules']);
        $id = $competition->save();

        if (!$id) {
            return $response
                ->withHeader('Location', UtilsHelper::base_url("/admin/campeonato/create"))
                ->withStatus(302);   
        }

        return $response
            ->withHeader('Location', UtilsHelper::base_url("/admin/campeonato/$id"))
            ->withStatus(302);   
    }

    public function show ($request, $response, $args) {
        AuthHelper::restrictToPermission(User::USER_LEVEL_ADMIN);
        $user = AuthHelper::getAuthenticatedUser();
        
        $competition = Competition::findById($args['id']);

        $data = compact(['user', 'competition']);

        View::render('layout/admin/header', $data);
        View::render('competition/show', $data);
        View::render('layout/admin/footer', $data);

        return $response;
    }

    public function edit ($request, $response, $args) {
        AuthHelper::restrictToPermission(User::USER_LEVEL_ADMIN);
        $user = AuthHelper::getAuthenticatedUser();
        
        /* TODO: 404 if not exists */
        $competition = Competition::findById($args['id']);

        $data = compact(['user', 'competition']);

        View::render('layout/admin/header', $data);
        View::render('competition/edit', $data);
        View::render('layout/admin/footer', $data);

        return $response;
    }

    public function update ($request, $response, $args) {
        AuthHelper::restrictToPermission(User::USER_LEVEL_ADMIN);
        $competition = Competition::findById($args['id']);
        $body = $request->getParsedBody();
        $competition->setAttr('title', $body['title']);
        $competition->setAttr('description', $body['description']);
        $competition->setAttr('rules', $body['rules']);
        $competition->setAttr('prizes', $body['prizes']);
        $competition->setAttr('headline', $body['headline']);
        $competition->save();

        return $response
            ->withHeader('Location', UtilsHelper::base_url("/admin/campeonato/".$args['id']))
            ->withStatus(302);      
    }

    public function delete ($request, $response, $args) {
        AuthHelper::restrictToPermission(User::USER_LEVEL_ADMIN);
        $competition = Competition::findById($args['id']);
        $competition->delete();
        return $response
            ->withHeader('Location', UtilsHelper::base_url("/admin/campeonato"))
            ->withStatus(302);  
    }
}