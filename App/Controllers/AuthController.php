<?php

namespace App\Controllers;

use App\Helpers\View;
use App\Helpers\AuthHelper;
use App\Helpers\UtilsHelper;

class AuthController {
    public function logout ($request, $response, $args) {
        AuthHelper::logout();
	    return $response
            ->withHeader('Location', $request->getUri() . "/..")
            ->withStatus(302);      
    }

    public function loginForm ($request, $response, $args) {

        View::render('layout/website/header');
        View::render('login');
        View::render('layout/website/footer');
        return  $response;
    }

    public function login ($request, $response, $args) {          
        $aLoginError 	= false;
        $aHasAccount 	= false;
        
        if (!isset($_POST['user'], $_POST['password'])) {
            View::render('layout/admin/header', $data);
            View::render('auth/login', array(
                'loginError' => true
            ));
            View::render('layout/admin/footer', $data);
            return $response;
        }

        $username = $_POST['user'];

        $user = AuthHelper::loginUsingPortal($username, $_POST['password']);

        if (!$user) {
            View::render('layout/admin/header', $data);
            View::render('auth/login', array(
                'loginError' => true
            ));
			View::render('layout/admin/footer', $data);
            return $response;
        }

        $_SESSION['user'] = $user->id;
        $_SESSION['request_uri'] = $request->getUri();

        return $response
            ->withHeader('Location', UtilsHelper::base_url("/perfil"))
            ->withStatus(302);  
    }

    public function profile ($request, $response, $args) {
        $user = AuthHelper::getAuthenticatedUser();

        $data = compact('user');

        View::render('layout/website/header', $data);
        View::render('auth/profile', $data);
        View::render('layout/website/footer', $data);
        return $response;
    }

    public function subscriptionForm ($request, $response, $args) {
        AuthHelper::allowNonAuthenticated();
	
        $aLoginError 	= false;
        $aIsUFFS 		= isset($_POST['uffs']) && $_POST['uffs'] == '1';
        $aHasAccount 	= false;

        View::render('auth/register', array(
            'loginError' => $aLoginError,
            'user' => @$_POST['user'],
            'uffs' => !isset($_POST['uffs']) ? '1' : $_POST['uffs'],
            'email' => @$_POST['email'],
            'name' => @$_POST['name'],
            'passworde' => @$_POST['passworde'],
            'password' => @$_POST['password'],
            'isLogin' => false
        ));
        return $response;
    }
}