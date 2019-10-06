<?php

namespace App\Helpers;

require_once dirname(__FILE__). '/../../vendor/rmccue/requests/library/Requests.php';

use App\Models\User;
use App\Helpers\View;

class AuthHelper {
	public static function hash($thePassword) {
		return md5($thePassword . PASSWORD_SALT);
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

	public static function restrictToPermission($level) {
		$title = '401';
		$isAuthenticated = AuthHelper::isAuthenticated();
		$user = AuthHelper::getAuthenticatedUser();
		if(!$isAuthenticated || !$user->isLevel($level)) {
			$data = compact(['user', 'title']);
			View::render('layout/admin/header', $data);
			View::render('errors/401', $data);
			View::render('layout/admin/footer', $data);
			exit();
		}
	}
	
	public static function logout() {
		unset($_SESSION['user']);
	}
	
	public static function isAuthenticated() {
		return isset($_SESSION['user']);
	}
	
	private static function formatIdUffsResult ($data) {
		return  (object) [
			'username' => $data->username,
			'uid' => $data->uid[0],
			'email' => $data->mail[0],
			'pessoa_id' => $data->pessoa_id[0],
			'name' => $data->cn[0],
			'cpf' => $data->employeeNumber[0],
			'token_id' => $data->token_id,
			'authenticated' => $data->authenticated
		];
	}

	public static function loginUsingPortal($username, $password) {
		$user_token = SELF::getLoginToken($username, $password);

		if(!isset($user_token)) {
			return [
				"user" => $username,
				"authenticated" => false
			];
		}

		$user_data = SELF::getUserInPortal($username, $user_token);
		if (!$user_data) { return null; }

		if (User::isUsernameAvailable($user_data->username)) {
			$user = SELF::getUserByData($user_data);

			if(is_numeric($username[0])){
				$user->cpf = str_replace(array('.', '-'),'', $username);
			}
			$user->save();
			return $user;
		}

		return User::findByUsername($user_data->username);
	}

	public static function getLoginToken ($username, $password) {
		$data = '{"authId":"eyAidHlwIjogIkpXVCIsICJhbGciOiAiSFMyNTYiIH0.eyAib3RrIjogImtranZqbG9uMGlicmJ0cDVkbGQ0NXZqajI4IiwgInJlYWxtIjogImRjPW9wZW5hbSxkYz1mb3JnZXJvY2ssZGM9b3JnIiwgInNlc3Npb25JZCI6ICJBUUlDNXdNMkxZNFNmY3paUU1LV2R1akQtRlJLOC05WVBMVjZBTDZLZGlaSm1Way4qQUFKVFNRQUNNREVBQWxOTEFCUXROREl3TnpBek1UQTJNREkyTXpneE1qWTFOZ0FDVXpFQUFBLi4qIiB9.7jwDw0grbOGJwHX05mjgt0-aKM8Y4R_sWjliPklsPYs","template":"","stage":"DataStore1","header":"Entre com seu IdUFFS","callbacks":[{"type":"NameCallback","output":[{"name":"prompt","value":"IdUFFS ou CPF"}],"input":[{"name":"IDToken1","value":"USUARIO"}]},{"type":"PasswordCallback","output":[{"name":"prompt","value":"Senha"}],"input":[{"name":"IDToken2","value":"SENHA"}]}]}';
		$data = str_replace("USUARIO", $username, $data);
		$data = str_replace("SENHA", $password, $data);

		$response = RequestHelper::post(
			'https://id.uffs.edu.br/id/json/authenticate?realm=/',
			json_decode($data)
		);

		$response = json_decode($response);
		if (!isset($response->tokenId)) {
			return null;
		}
		return $response->tokenId;
	}

	public static function getUserInPortal ($username, $user_token) {
		$userdata = RequestHelper::get(
			"https://id.uffs.edu.br/id/json/users/$username",
			['headers' => ["Cookie: iPlanetDirectoryPro=$user_token"]]
		);
		$userdata = json_decode($userdata);

		if (isset($userdata->code) && $userdata->code == 401) {
			return null;
		}

		if (isset($userdata->code) && $userdata->code == 403) {
			$matches = null;
			preg_match('/id=(.*?),ou=user/',$userdata->message, $matches);
			$username_test = $matches[1];
			return SELF::getUserInPortal($username_test, $user_token);
		}

		$userdata->token_id = $user_token;
		$userdata->authenticated = true;
		return SELF::formatIdUffsResult($userdata);
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