<?php

namespace App\Controllers;

use App\Models\User;
use App\Helpers\View;
use App\Helpers\AuthHelper;
use App\Helpers\FlashMessage;
use App\Helpers\UtilsHelper;

class AuthController {
    public function logout ($request, $response, $args) {
        AuthHelper::logout();
	    return $response
            ->withHeader('Location', $request->getUri() . "/..")
            ->withStatus(302);
    }

    public function subscription ($request, $response, $args) {
        $user = AuthHelper::getAuthenticatedUser();
        if ($user) {
            return $response
                ->withHeader('Location', UtilsHelper::base_url("/perfil"))
                ->withStatus(302);  
        }

        View::render('layout/website/header');
        View::render('auth/subscription');
        View::render('layout/website/footer');
        return  $response;
    } 

    public function studantLoginForm ($request, $response, $args) {
        $user = AuthHelper::getAuthenticatedUser();

        if ($user) {
            return $response
                ->withHeader('Location', UtilsHelper::base_url("/perfil"))
                ->withStatus(302);  
        }

        View::render('layout/website/header');
        View::render('auth/studant-login');
        View::render('layout/website/footer');
        return  $response;
    }

    public function studantLogin ($request, $response, $args) {          
        if (!isset($_POST['user'], $_POST['password'])) {
            return $response
                ->withHeader('Location', UtilsHelper::base_url("/inscricao/aluno"))
                ->withStatus(302);  
        }

        $username = $_POST['user'];

        $user = AuthHelper::loginUsingPortal($username, $_POST['password']);

        if (!$user) {
            FlashMessage::setMessage('loginError', 'Login ou senha inválidos, tente novamente');
            return $response
                ->withHeader('Location', UtilsHelper::base_url("/inscricao/aluno"))
                ->withStatus(302);
        }

        $_SESSION['user'] = $user->id;
        $_SESSION['request_uri'] = $request->getUri();

        return $response
            ->withHeader('Location', UtilsHelper::base_url("/perfil"))
            ->withStatus(302);
    }

    public function externalRegisterForm ($request, $response, $args) {
        $user = AuthHelper::getAuthenticatedUser();

        if ($user) {
            return $response
                ->withHeader('Location', UtilsHelper::base_url("/perfil"))
                ->withStatus(302);  
        }

        View::render('layout/website/header');
        View::render('auth/external-register');
        View::render('layout/website/footer');
        return $response;
    }

    public function externalRegister ($request, $response, $args) {
        if (empty($_POST['user']) || empty($_POST['name']) || empty($_POST['password']) || empty($_POST['password_confirm'])) {
            return $response
                ->withHeader('Location', UtilsHelper::base_url("/inscricao/visitante/cadastro"))
                ->withStatus(302);  
        }

        if ($_POST['password'] != $_POST['password_confirm']) {
            FlashMessage::setMessage('registerError', 'As senhas precisam ser iguais');
            return $response
                ->withHeader('Location', UtilsHelper::base_url("/inscricao/visitante/cadastro"))
                ->withStatus(302);
        }

        $user = new User();
        $user->name = $_POST['name'];
        $user->login = $_POST['user'];
        $user->email = $_POST['user'];
        $user->password = AuthHelper::hash($_POST['password']);
        $user->type = User::USER_LEVEL_EXTERNAL;
        $user->save();
        $_SESSION['user'] = $user->id;
        return $response
            ->withHeader('Location', UtilsHelper::base_url("/perfil"))
            ->withStatus(302);
    }

    public function externalLoginForm ($request, $response, $args) {
        $user = AuthHelper::getAuthenticatedUser();

        if ($user) {
            return $response
                ->withHeader('Location', UtilsHelper::base_url("/perfil"))
                ->withStatus(302);  
        }

        View::render('layout/website/header');
        View::render('auth/external-login');
        View::render('layout/website/footer');
        return $response;
    }

    public function externalLogin ($request, $response, $args) {
        $user = AuthHelper::getAuthenticatedUser();
        if ($user) {
            return $response
                ->withHeader('Location', UtilsHelper::base_url("/perfil"))
                ->withStatus(302);  
        }

        if (!isset($_POST['user'], $_POST['password'])) {
            return $response
                ->withHeader('Location', UtilsHelper::base_url("/inscricao/visitante/login"))
                ->withStatus(302);  
        }

        $user = User::findByCredentials($_POST['user'], $_POST['password']);
        if (!$user) {
            FlashMessage::setMessage('loginError', 'Login ou senha inválidos, tente novamente');
            return $response
                ->withHeader('Location', UtilsHelper::base_url("/inscricao/visitante/login"))
                ->withStatus(302);
        }

        $_SESSION['user'] = $user->id;
        return $response
            ->withHeader('Location', UtilsHelper::base_url("/perfil"))
            ->withStatus(302);
    }

    
    public function profileUpdate ($request, $response, $args) {
        $user = AuthHelper::getAuthenticatedUser();
        $user->registration = @$_POST['registration'];
        $user->save();
        return $response
            ->withHeader('Location', UtilsHelper::base_url("/perfil"))
            ->withStatus(302);
    }

    public function profile ($request, $response, $args) {
        $user = AuthHelper::getAuthenticatedUser();

        if (!$user) {
            return $response
            ->withHeader('Location', UtilsHelper::base_url("/inscricao"))
            ->withStatus(302);  
        }

        $data = compact('user');

        View::render('layout/website/header', $data);
        View::render('auth/profile', $data);
        View::render('layout/website/footer', $data);
        return $response;
    }
}
