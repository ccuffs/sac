<?php

namespace App\Helpers;

require_once dirname(__FILE__). '/../../vendor/rmccue/requests/library/Requests.php';

use App\Models\User;
use App\Helpers\View;
use CCUFFS\Auth\AuthIdUFFS;

class AuthHelper {
	public static function hash($thePassword) {
		return sha1($thePassword . PASSWORD_SALT);
	}
	
	public static function getAuthenticatedUser() {
		$user_id = @$_SESSION['user'];
		if (!$user_id) return null;
		return User::findById($user_id);
	}
	
	public static function allowNonAuthenticated() {
		if(AuthHelper::isAuthenticated()) {
			header('Location: index.php');
			exit();
		}
	}
	
	public static function allowAuthenticated() {
		$user = AuthHelper::getAuthenticatedUser();
        $title = '401';
        $data = compact(['user', 'title']);
		if(!AuthHelper::isAuthenticated()) {
			View::render('layout/admin/header', $data);
			View::render('errors/401', $data);
			View::render('layout/admin/footer', $data);
			exit();
		}
	}

	public static function restrictToPermission($level, $type = "HTML") {
		$title = '401';
		$isAuthenticated = AuthHelper::isAuthenticated();
		$user = AuthHelper::getAuthenticatedUser();
		$hasAccess = $isAuthenticated && $user->hasPermission($level);
		if(!$hasAccess && $type == "HTML") {
			$data = compact(['user', 'title']);
			View::render('layout/admin/header', $data);
			View::render('errors/401', $data);
			View::render('layout/admin/footer', $data);
			exit();
		} else if (!$hasAccess && $type == "JSON") {
			header("message: 'Usuário não autorizado!'");
			header("Content-Type: text/html; charset=UTF-8");
			http_response_code(401);
			exit();
		}
	}
	
	public static function logout() {
		unset($_SESSION['user']);
	}
	
	public static function isAuthenticated() {
		return isset($_SESSION['user']);
	}
	
	public static function loginUsingPortal($username, $password) {
		$auth = new AuthIdUFFS();

		$user_data = $auth->login([
			'user'     => $username,
			'password' => $password
		]);
		
		if (!$user_data) { return null; }

		if (User::isUsernameAvailable($user_data->username)) {
			$user = SELF::getUserByData($user_data);

			if(is_numeric($username[0])){
				$user->cpf = str_replace(array('.', '-'),'', $username);
			}
			$user->type = User::USER_LEVEL_UFFS;
			$user->save();
			return $user;
		}

		return User::findByUsername($user_data->username);
	}

	private static function getUserByData ($data) {
		$user = new User();
		$user->login = $data->username;
		$user->email = $data->email;
		$user->name = $data->name;
		$user->cpf = $data->cpf;
		return $user;
	} 
}