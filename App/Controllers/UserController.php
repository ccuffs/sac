<?php

namespace App\Controllers;

use App\Helpers\AuthHelper;
use App\Models\User;
use App\Helpers\View;

class UserController {

    public function index($request, $response, $args) {
        
        AuthHelper::allowAuthenticated();
        $users = User::findByRole([User::USER_LEVEL_UFFS, User::USER_LEVEL_ADMIN, User::CO_ORGANIZER]);

        View::render('auth/users', $users);

        return $response;
    }

    public function update($request, $response, $args) {

        AuthHelper::allowAuthenticated();

        if(isset($_REQUEST['type']) && isset($args['id'])){
            $userNewRole = $_REQUEST['type'];
            $id = $args['id'];
            $user = User::getById($id);
            $user->type = $userNewRole;
            $user->save();
            return $response->withStatus(200);
        }
        return $response->withStatus(500);
    }

}

