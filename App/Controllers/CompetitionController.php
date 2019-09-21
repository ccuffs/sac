<?php

namespace App\Controllers;

use App\Helpers\View;
use App\Models\User;
use App\Models\Competition;
use App\Helpers\AuthHelper;

class CompetitionController {
    public function index ($request, $response, $args) {
        AuthHelper::restrictToPermission(User::USER_LEVEL_ADMIN);
        $user = AuthHelper::getAuthenticatedUser();
        
        $data = [
            'title' => 'Competição',
            'user' => $user,
            'events' => Competition::findAll()
        ];

        View::render('layout/header', $data);
        View::render('competition/index', $data);
        View::render('layout/footer', $data);

        return $response;
    }

    public function create ($request, $response, $args) {
        AuthHelper::allowAuthenticated();
        $data			= array();
        $user 			= User::getById($_SESSION['user']);
        $isAdmin 		= $user->isLevel(User::USER_LEVEL_ADMIN);
        $competition 	= isset($_REQUEST['id']) ? $_REQUEST['id'] : 0;
        $data['user'] = $user;
        $data['createdOrUpdated'] 	= Competition::create($_POST);

        if (!$isAdmin) {
            View::render('restricted');
            return $response;
        }

        $data['competition'] = Competition::getById($competition);

        View::render('competition-manager', $data);
        return $response;
    }

    /* TODO: test this function */
    public function show ($request, $response, $args) {
        AuthHelper::restrictToPermission(User::USER_LEVEL_ADMIN);
        $user = AuthHelper::getAuthenticatedUser();
        
        $competition = Competition::findById($args['id']);
        $title = 'Evento';

        $data = compact(['user', 'competition', 'title']);

        View::render('layout/header', $data);
        View::render('competition/show', $data);
        View::render('layout/footer', $data);

        return $response;
    }
}