<?php

require_once dirname(__FILE__).'/config.php';
require_once dirname(__FILE__). '/../vendor/rmccue/requests/library/Requests.php';


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

//TODO: this function isn't being used anymore
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

function authLoginUsingPortal($username, $password){
	Requests::register_autoloader();
	$headers = array(
	    'Accept-API-Version' => 'protocol=1.0,resource=2.0',
	    'Sec-Fetch-Mode' => 'cors',
	    'Origin' => 'https://id.uffs.edu.br',
	    'Accept-Encoding' => 'gzip, deflate, br',
	    'X-Password' => 'anonymous',
	    'Accept-Language' => 'en-US,en;q=0.9',
	    'X-Requested-With' => 'XMLHttpRequest',
	    'Connection' => 'keep-alive',
	    'X-Username' => 'anonymous',
	    'User-Agent' => 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/76.0.3809.87 Safari/537.36',
	    'Content-Type' => 'application/json',
	    'Accept' => 'application/json, text/javascript, */*; q=0.01',
	    'Cache-Control' => 'no-cache',
	    'Referer' => 'https://id.uffs.edu.br/id/XUI/',
	    'Sec-Fetch-Site' => 'same-origin',
	    'X-NoSession' => 'true',
	    'Cookie' => 'JSESSIONID=F9D685160995A7AED0A89FF926DFF23C; _ga=GA1.3.1694994789.1564943473; i18next=en-US; amlbcookie=01'
	);
	$data = '{"authId":"eyAidHlwIjogIkpXVCIsICJhbGciOiAiSFMyNTYiIH0.eyAib3RrIjogImtranZqbG9uMGlicmJ0cDVkbGQ0NXZqajI4IiwgInJlYWxtIjogImRjPW9wZW5hbSxkYz1mb3JnZXJvY2ssZGM9b3JnIiwgInNlc3Npb25JZCI6ICJBUUlDNXdNMkxZNFNmY3paUU1LV2R1akQtRlJLOC05WVBMVjZBTDZLZGlaSm1Way4qQUFKVFNRQUNNREVBQWxOTEFCUXROREl3TnpBek1UQTJNREkyTXpneE1qWTFOZ0FDVXpFQUFBLi4qIiB9.7jwDw0grbOGJwHX05mjgt0-aKM8Y4R_sWjliPklsPYs","template":"","stage":"DataStore1","header":"Entre com seu IdUFFS","callbacks":[{"type":"NameCallback","output":[{"name":"prompt","value":"IdUFFS ou CPF"}],"input":[{"name":"IDToken1","value":"USUARIO"}]},{"type":"PasswordCallback","output":[{"name":"prompt","value":"Senha"}],"input":[{"name":"IDToken2","value":"SENHA"}]}]}';

	$data = str_replace("USUARIO", $username, $data);
	$data = str_replace("SENHA", $password, $data);


	$response = Requests::post('https://id.uffs.edu.br/id/json/authenticate?realm=/', $headers, $data);

	$response = json_decode($response->body);


	if(isset($response->code)) {
		$message["user"] = $username;
		$message["authenticated"] = false;
	}
	else{
		$message["user"] = $username;
		$message["authenticated"] = true;
	}

	//echo json_encode($message);
	return $message;
}

?>