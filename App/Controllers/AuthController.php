<?php

namespace App\Controllers;

use \core\View;

class AuthController {
    public function logout ($request, $response, $args) {
        authLogout();
	    return $response
            ->withHeader('Location', $request->getUri() . "/..")
            ->withStatus(302);      
    }

    public function loginForm ($request, $response, $args) {
        authAllowNonAuthenticated();
	
        $aLoginError = false;
        $aIsUFFS = isset($_POST['uffs']) && $_POST['uffs'] == '1';
        $aHasAccount = false;
        
        View::render('login', array(
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
        authAllowNonAuthenticated();
	
        $aLoginError 	= false;
        $aIsUFFS 		= isset($_POST['uffs']) && $_POST['uffs'] == '1';
        $aHasAccount 	= false;
        
        if (isset($_POST['user'], $_POST['password'])) {
            // TODO: fix this because the login string might have . and -
            $aCpf = str_replace(array('.', '-', ' ', ','), '', $_POST['user']);
            $aCpf = ltrim($aCpf,  '0');
            
            $aHasAccount = authIsValidUser($aCpf, $_POST['password']);
            $aUser = '';
            
            if ($aHasAccount) {
                $aUser = $aCpf;	

            } else {
                // TODO: it would be nice to have some sort of auth plugins here :)
                //$aMoodleInfo = authLoginUsingMoodle($aCpf, $_POST['password']);

                $aPortalInfo = authLoginUsingPortal($aCpf, $_POST['password']);

                if ($aIsUFFS && $aPortalInfo != null) {
                    $aPortalInfo['email'] = $_POST['email'];
                    $aPortalInfo['user'] = $_POST['email'];

                    // TODO would be better if a user logins only with users idUffs

                    $aHasAccount = authCreateLocalAccountUsingLoginMoodle($aPortalInfo, $aCpf, $_POST['password']);

                    if($aHasAccount) {
                        $aUser = $aCpf;
                    } else {
                        $aLoginError = true;
                    }
                } else {
                    if($aIsUFFS) {
                        $aLoginError = true;
                    } else {
                        // Create account for external attendant
                        $_POST['password'] = @$_POST['passworde'];
                        $aHasAccount = authCreateLocalAccountUsingInfos($_POST, $aCpf, $_POST['password']);
                
                        if($aHasAccount) {
                            $aUser = $aCpf;
                        } else {
                            $aLoginError = true;
                        }
                    }
                }
            }

            if($aHasAccount) {
                authLogin($aUser);
                return $response
                    ->withHeader('Location', $request->getUri() . "/..")
                    ->withStatus(302);    
            }
        } else {
            $aLoginError = true;
        }

        View::render('login', array(
            'loginError' 	=> $aLoginError,
            'user'			=> @$_POST['user'],
            'uffs'			=> !isset($_POST['uffs']) ? '1' : $_POST['uffs'],
            'email'			=> @$_POST['email'],
            'name'			=> @$_POST['name'],
            'passworde'		=> @$_POST['passworde'],
            'password'		=> @$_POST['password'],
            'isLogin'		=> true
        ));

        return $response;
    }

    public function subscriptionForm ($request, $response, $args) {
        authAllowNonAuthenticated();
	
        $aLoginError 	= false;
        $aIsUFFS 		= isset($_POST['uffs']) && $_POST['uffs'] == '1';
        $aHasAccount 	= false;

        View::render('login', array(
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