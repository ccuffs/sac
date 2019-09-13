<?php

namespace App\Controllers;

use App\Helpers\View;
use App\Helpers\AuthHelper;

class AuthController {
    public function logout ($request, $response, $args) {
        AuthHelper::logout();
	    return $response
            ->withHeader('Location', $request->getUri() . "/..")
            ->withStatus(302);      
    }

    public function loginForm ($request, $response, $args) {
        AuthHelper::allowNonAuthenticated();
	
        $aLoginError = false;
        $aIsUFFS = isset($_POST['uffs']) && $_POST['uffs'] == '1';
        $aHasAccount = false;
        
        View::render('auth/login', array(
            'loginError' => $aLoginError,
            'user' => @$_POST['user'],
            'uffs' => !isset($_POST['uffs']) ? '1' : $_POST['uffs'],
            'email' => @$_POST['email'],
            'name' => @$_POST['name'],
            'passworde' => @$_POST['passworde'],
            'password' => @$_POST['password'],
            'isLogin' => true
        ));
        return  $response;
    }

    public function login ($request, $response, $args) {
        AuthHelper::allowNonAuthenticated();
        $aLoginError 	= false;
        $aHasAccount 	= false;
        
        if (!isset($_POST['user'], $_POST['password'])) {
            View::render('auth/login', array(
                'loginError' => true
            ));
            return $response;
        }

        $username = $_POST['user'];

        $user = AuthHelper::loginUsingPortal($username, $_POST['password']);

        if (!$user) {
            View::render('auth/login', array(
                'loginError' => true
            ));
            return $response;
        }

        $_SESSION['user'] = $user->id;

        return $response
            ->withHeader('Location', $request->getUri() . "/..")
            ->withStatus(302);    
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