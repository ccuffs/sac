<?php

require_once dirname(__FILE__).'/config.php';


function authIsValidUser($theUserLogin, $thePassword) {
	global $gDb;
	
	$aQuery = $gDb->prepare("SELECT id FROM users WHERE login = ? AND password = ?");
	$aRet = false;

	$aQuery->execute(array($theUserLogin, authHash($thePassword)));
	
	return $aQuery->rowCount() == 1;
}

function authHash($thePassword) {
	return md5($thePassword . PASSWORD_SALT);
}

function authLogin($theUserLogin) {
	global $gDb;
	
	$aQuery = $gDb->prepare("SELECT id, name, type FROM users WHERE login = ?");
	
	if ($aQuery->execute(array($theUserLogin))) {	
		$aUser = $aQuery->fetch();
		
		$_SESSION['authenticaded'] = true;
		$_SESSION['user'] = array('name' => $aUser['name'], 'id' => $aUser['id'], 'type' => $aUser['type']);
	}
}

function authGetAuthenticatedUserInfo() {
	return userGetById($_SESSION['user']['id']);
}

function authAllowNonAuthenticated() {
	if(authIsAuthenticated()) {
		header('Location: ' . (authIsAdmin() ? 'admin.index.php' : 'index.php'));
		exit();
	}
}

function authAllowAdmin() {
	if(!authIsAuthenticated()) {
		header('Location: login.php');
		exit();
		
	} else if(!authIsAdmin()){
		header('Location: restricted.php');
		exit();
	}
}

function authAllowAuthenticated() {
	if(!authIsAuthenticated()) {
		header('Location: login.php');
		exit();
	}
}

function authLogout() {
	unset($_SESSION);
	session_destroy();
}

function authIsAuthenticated() {
	return isset($_SESSION['authenticaded']) && $_SESSION['authenticaded'];
}

function authIsAdmin() {
	return isset($_SESSION['admin']) && $_SESSION['admin'] == true;
}

function authCreateLocalAccountUsingLoginMoodle($theUserInfo, $theCpf, $thePassword) {
	global $gDb;
	
	$aUser = null;
	$aQuery = $gDb->prepare("INSERT INTO users (login, password, name, email, type) VALUES (?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE password = ?"); // TODO: fix this!
	
	$aEmail = $theUserInfo['email'];
	$aPwd	= authHash($thePassword);
	$aOk	= strlen($aEmail) >= 5;
	
	if($aOk) {
		$aQuery->execute(array($theCpf, $aPwd, $theUserInfo['user'], $aEmail, USER_LEVEL_UFFS, $aPwd));
		$aOk = $aQuery->rowCount() != 0;
		
	}
	return $aOk;
}

function authCreateLocalAccountUsingInfos($theUserInfo, $theCpf, $thePassword) {
	global $gDb;
	
	$aUser = null;
	$aQuery = $gDb->prepare("INSERT INTO users (login, password, name, email, type) VALUES (?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE password = ?"); // TODO: fix this!
	
	$aEmail = $theUserInfo['email'];
	$aPwd	= authHash($thePassword);
	$aOk	= strlen($theCpf) >= 5 && strlen($thePassword) > 1 &&  strlen($theUserInfo['name']) >= 5 &&  strlen($aEmail) >= 5;
	
	if($aOk) {
		$aQuery->execute(array($theCpf, $aPwd, $theUserInfo['name'], $aEmail, USER_LEVEL_EXTERNAL, $aPwd));
		$aOk = $aQuery->rowCount() != 0;
	}
	
	return $aOk;
}

function authLoginUsingMoodle($theUser, $thePassword) {
	$aRet = null;
	$aCh = curl_init('https://moodle.uffs.edu.br/login/index.php');
	$aData = 'username='.urlencode($theUser).'&password='.urlencode($thePassword);
	
	curl_setopt($aCh, CURLOPT_RETURNTRANSFER , 1);
	curl_setopt($aCh, CURLOPT_PORT, 443);
	curl_setopt($aCh, CURLOPT_POSTFIELDS,  $aData);
	curl_setopt($aCh, CURLOPT_HEADER, 1);
	curl_setopt($aCh, CURLOPT_POST, 1);
	curl_setopt($aCh, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($aCh, CURLOPT_SSL_VERIFYPEER, 0); 
	
	$aPage = curl_exec($aCh);
	
	if ($aPage !== false) {
		if (strpos($aPage, '<input type="password" name="password"') === false && strpos($aPage, '<meta http-equiv="refresh" content="0; url=https://moodle.uffs.edu.br/my/') !== false) {
			// Valid user and password.
			$aMatches = array();
			
			preg_match_all('/^Set-Cookie:\s*([^;]*)/mi', $aPage, $aMatches);
			unset($aMatches[1][0]);
			
			curl_setopt($aCh, CURLOPT_COOKIE, implode('; ', $aMatches[1]));
			curl_setopt($aCh, CURLOPT_URL, 'https://moodle.uffs.edu.br/my/');
			
			$aPage = curl_exec($aCh);
			
			if(strpos($aPage, 'HTTP/1.1 200 OK') !== false) {
				$aMatches = array();
				preg_match_all('/.*">(.*) \(.*\)<\/a>/', $aPage, $aMatches);

				$aRet = array('user' => 'Desconhecido');
				$aRet['user'] = isset($aMatches[1][0]) ? ucwords(strtolower($aMatches[1][0])) : 'Desconhecido';
			}			
		} else {
			// Invalid user or password
			$aRet = null;
			
		}
	}
	
	curl_close($aCh);
	return $aRet;
}

?>