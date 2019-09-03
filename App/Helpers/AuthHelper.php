<?php

namespace App\Helpers;

require_once dirname(__FILE__). '/../../vendor/rmccue/requests/library/Requests.php';

use App\Models\User;
use App\Helpers\DatabaseHelper;
use App\Helpers\AuthHelper;

class AuthHelper {
	public static function isValidUser($theUserLogin, $thePassword) {
		$conn = DatabaseHelper::getConn();
		
		$aQuery = $conn->prepare("SELECT id FROM users WHERE login = ? AND password = ?");
		$aRet = false;
	
		$aQuery->execute(array($theUserLogin, AuthHelper::hash($thePassword)));
		
		return $aQuery->rowCount() == 1;
	}
	
	public static function hash($thePassword) {
		return md5($thePassword . PASSWORD_SALT);
	}
	
	public static function login($theUserLogin) {
		$conn = DatabaseHelper::getConn();
		
		$aQuery = $conn->prepare("SELECT id, name, type FROM users WHERE login = ?");
		
		if ($aQuery->execute(array($theUserLogin))) {	
			$aUser = $aQuery->fetch();
			
			$_SESSION['authenticaded'] = true;
			$_SESSION['user'] = array('name' => $aUser['name'], 'id' => $aUser['id'], 'type' => $aUser['type']);
		}
	}
	
	public static function getAuthenticatedUserInfo() {
		return User::getById($_SESSION['user']['id']);
	}
	
	public static function allowNonAuthenticated() {
		if(AuthHelper::isAuthenticated()) {
			header('Location: ' . (AuthHelper::isAdmin() ? 'admin.index.php' : 'index.php'));
			exit();
		}
	}
	
	public static function allowAdmin() {
		if(!AuthHelper::isAuthenticated()) {
			header('Location: login.php');
			exit();
			
		} else if(!AuthHelper::isAdmin()){
			header('Location: restricted.php');
			exit();
		}
	}
	
	public static function allowAuthenticated() {
		if(!AuthHelper::isAuthenticated()) {
			header('Location: login.php');
			exit();
		}
	}
	
	public static function logout() {
		unset($_SESSION);
		session_destroy();
	}
	
	public function isAuthenticated() {
		return isset($_SESSION['authenticaded']) && $_SESSION['authenticaded'];
	}
	
	public function isAdmin() {
		return isset($_SESSION['admin']) && $_SESSION['admin'] == true;
	}
	
	public static function createLocalAccountUsingLoginMoodle($theUserInfo, $theCpf, $thePassword) {
		$conn = DatabaseHelper::getConn();
		
		$aUser = null;
		$aQuery = $conn->prepare("INSERT INTO users (login, password, name, email, type) VALUES (?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE password = ?"); // TODO: fix this!
		
		$aEmail = $theUserInfo['email'];
		$aPwd	= AuthHelper::hash($thePassword);
		$aOk	= strlen($aEmail) >= 5;
		
		if($aOk) {
			$aQuery->execute(array($theCpf, $aPwd, $theUserInfo['user'], $aEmail, User::USER_LEVEL_UFFS, $aPwd));
			$aOk = $aQuery->rowCount() != 0;
			
		}
		return $aOk;
	}
	
	public static function createLocalAccountUsingInfos($theUserInfo, $theCpf, $thePassword) {
		$conn = DatabaseHelper::getConn();
		
		$aUser = null;
		$aQuery = $conn->prepare("INSERT INTO users (login, password, name, email, type) VALUES (?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE password = ?"); // TODO: fix this!
		
		$aEmail = isset($theUserInfo['email']) ? $theUserInfo['email'] : '';
		$aPwd	= AuthHelper::hash($thePassword);
		$aOk	= strlen($theCpf) >= 5 && strlen($thePassword) > 1 &&  strlen($theUserInfo['name']) >= 5 &&  strlen($aEmail) >= 5;
		
		if($aOk) {
			$aQuery->execute(array($theCpf, $aPwd, $theUserInfo['name'], $aEmail, User::USER_LEVEL_EXTERNAL, $aPwd));
			$aOk = $aQuery->rowCount() != 0;
		}
		
		return $aOk;
	}
	
	public static function loginUsingPortal($username, $password){
		$data = '{"authId":"eyAidHlwIjogIkpXVCIsICJhbGciOiAiSFMyNTYiIH0.eyAib3RrIjogImtranZqbG9uMGlicmJ0cDVkbGQ0NXZqajI4IiwgInJlYWxtIjogImRjPW9wZW5hbSxkYz1mb3JnZXJvY2ssZGM9b3JnIiwgInNlc3Npb25JZCI6ICJBUUlDNXdNMkxZNFNmY3paUU1LV2R1akQtRlJLOC05WVBMVjZBTDZLZGlaSm1Way4qQUFKVFNRQUNNREVBQWxOTEFCUXROREl3TnpBek1UQTJNREkyTXpneE1qWTFOZ0FDVXpFQUFBLi4qIiB9.7jwDw0grbOGJwHX05mjgt0-aKM8Y4R_sWjliPklsPYs","template":"","stage":"DataStore1","header":"Entre com seu IdUFFS","callbacks":[{"type":"NameCallback","output":[{"name":"prompt","value":"IdUFFS ou CPF"}],"input":[{"name":"IDToken1","value":"USUARIO"}]},{"type":"PasswordCallback","output":[{"name":"prompt","value":"Senha"}],"input":[{"name":"IDToken2","value":"SENHA"}]}]}';
		$data = str_replace("USUARIO", $username, $data);
		$data = str_replace("SENHA", $password, $data);

		$response = RequestHelper::post(
			'https://id.uffs.edu.br/id/json/authenticate?realm=/',
			json_decode($data)
		);

		$response = json_decode($response);

		if(!isset($response->tokenId)) {
			return [
				"user" => $username,
				"authenticated" => false
			];
		}

		$token_id = $response->tokenId;

		$userdata = RequestHelper::get(
			"https://id.uffs.edu.br/id/json/users/$username",
			['headers' => ["Cookie: iPlanetDirectoryPro=$token_id"]]
		);

		$userdata = json_decode($userdata);

		$userdata->token_id = $token_id;

		return $userdata;
	}
}