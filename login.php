<?php 	
	require_once dirname(__FILE__).'/inc/globals.php';
	
	authAllowNonAuthenticated();
	
	$aLoginError 	= false;
	$aIsUFFS 		= isset($_POST['uffs']) && $_POST['uffs'] == '1';
	$aHasAccount 	= false;
	
	if(count($_POST) > 0) {
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
				header('Location: index.php');
				exit();
			}
		} else {
			$aLoginError = true;
		}
	}
	
	View::render('login', array(
		'loginError' 	=> $aLoginError,
		'user'			=> @$_POST['user'],
		'uffs'			=> !isset($_POST['uffs']) ? '1' : $_POST['uffs'],
		'email'			=> @$_POST['email'],
		'name'			=> @$_POST['name'],
		'passworde'		=> @$_POST['passworde'],
		'password'		=> @$_POST['password'],
		'isLogin'		=> isset($_REQUEST['login'])
	));
?>