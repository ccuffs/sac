<?php

namespace App\Controllers;

use App\Helpers\AuthHelper;
use App\Models\User;
use App\Helpers\View;

class UserController {

    private $responseMessage = array();

    public function index($request, $response, $args) {
        
        AuthHelper::allowAuthenticated();
        $users = User::findByRole([User::USER_LEVEL_UFFS, User::USER_LEVEL_ADMIN, User::USER_CO_ORGANIZER]);

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
            $this->responseMessage['message'] = "Permissao atualizada com sucesso!";
            return $response->withJson($this->responseMessage, 200);
        }
        $this->responseMessage['message'] = "Ocorre algum erro, se aí troxa";
        return $response->withJson($this->responseMessage, 500);
    }

}

