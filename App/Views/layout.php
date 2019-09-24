<?php

use App\Helpers\View;
use App\Models\User;
use App\Helpers\AuthHelper;
use App\Helpers\UtilsHelper;

function layoutNavBar() {
	$aPage = basename($_SERVER['PHP_SELF']);
	
	echo '<nav class="navbar navbar-default" role="navigation">';
		echo '<div class="container">';
			echo '<div class="navbar-header">';
				echo '<a class="navbar-brand" href="'.UtilsHelper::base_url("/").'" title="Ir para página inicial"><i class="fa fa-calendar"/></i> Programação</a>';
			echo '</div>';
			
			echo '<div class="collapse navbar-collapse">';
				$user = null;
				
				if (AuthHelper::isAuthenticated()) {
					$user = User::getById($_SESSION['user']);
					
					echo '<ul class="nav navbar-nav">';
						//echo '<li '.($aPage == 'challenges.php' 	? 'class="active"' : '').'><a href="challenges.php">Desafios</a></li>';
						//echo '<li '.($aPage == 'assignments.php' 	? 'class="active"' : '').'><a href="assignments.php"></a></li>';
					echo '</ul>';
				}
				
				layoutUserBar($user);
					
				if(AuthHelper::isAuthenticated()) {
					layoutAdminNavBar($user);
				}
			echo '</div>';
		echo '</div>';
	echo '</nav>';
}

function layoutAdminNavBar($user) {
	$aPage = basename($_SERVER['PHP_SELF']);

	if (!$user->isLevel(User::USER_LEVEL_ADMIN)) {
		return;
	}
	
	echo '<ul class="nav navbar-nav navbar-right">';
		echo '<li class="dropdown">';
			echo '<a class="dropdown-toggle" data-toggle="dropdown" href="#">Ações <b class="caret"></b></a>';
			echo '<ul class="dropdown-menu" role="menu">';
				echo '<li role="presentation" class="dropdown-header">Programação</li>';
				echo '<li><a href="'.UtilsHelper::base_url("/admin/evento").'">Criar evento</a></li>';
				echo '<li><a href="'.UtilsHelper::base_url("/admin/campeonato").'">Criar campeonato</a></li>';
				
				echo '<li class="divider"></li>';
				echo '<li role="presentation" class="dropdown-header">Inscrições</li>';
				echo '<li><a href="'.UtilsHelper::base_url("/admin/inscricoes").'">Listar</a></li>';
				echo '<li><a href="'.UtilsHelper::base_url("/admin/pagamento").'">Pagamentos</a></li>';

				echo '<li class="divider"></li>';
				echo '<li role="presentation" class="dropdown-header">Gerenciar Permissões</li>';
				echo '<li><a href="'.UtilsHelper::base_url("/admin/permissoes").'">Usuários</a></li>';
				
				echo '<li class="divider"></li>';
				echo '<li role="presentation" class="dropdown-header">Frequência</li>';
				echo '<li><a href="javascript:void(0);">Gerenciar</a></li>';
			echo '</ul>';
		echo '</li>';
	echo '</ul>';
}

function layoutUserBar($user) {
	$is_admin = $user && $user->isLevel(User::USER_LEVEL_ADMIN);
	$aClassLink	= $is_admin ? 'btn-danger' : 'btn-primary';
	echo '<ul class="nav navbar-nav navbar-right">';
		if (AuthHelper::isAuthenticated()) {
			echo '<li style="margin-top: -5px;">';
				layoutPrintUser($user->id, $user, true);
			echo '</li>';

			echo '<li class="dropdown">';
				echo '<a class="dropdown-toggle" data-toggle="dropdown" href="#"><b class="caret"></b></a>';
				echo '<ul class="dropdown-menu" role="menu">';
				echo '<li><a href="'.UtilsHelper::base_url("/logout").'"><i class="fa fa-sign-out"></i> Sair</a></li>';
				echo '</ul>';				
			echo '</li>';
		} else {
			echo '<li class="dropdown">';
				echo '<button class="btn btn-info" onclick="window.location=\'inscricao\';" style="margin-top: 7px;"><span class="fa fa-user"></span> Inscrever-se</button> ';
				echo '<button class="btn btn-success" onclick="window.location=\'login\';" style="margin-top: 7px;"><span class="fa fa-user"></span> Login</button>';
			echo '</li>';
		}
	echo '</ul>';
}

function layoutHeader($theTitle) {
	echo '<!DOCTYPE html>';
	echo '<html lang="en">';
	echo '<head>';
		echo '<meta charset="utf-8">';
		echo '<title>'.(empty($theTitle) ? '' : $theTitle).' | Semana Acadêmica Ciência da Computação - 17 a 21 de outubro de 2014</title>';
		echo '<meta name="description" content="">';
		echo '<meta name="author" content="">';
		
		echo '<!-- Le HTML5 shim, for IE6-8 support of HTML elements -->';
		echo '<!--[if lt IE 9]>';
		echo '<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>';
		echo '<![endif]-->';
		
		$aRandURLs = '?20141113';
		$aRandURLs .= DEBUG_MODE ? rand(20, 9999) : '';
		
		echo '<!-- Le styles -->';
		echo '<link href="'.UtilsHelper::base_url('/css/bootstrap.css').'" rel="stylesheet">';
		echo '<link href="'.UtilsHelper::base_url('/css/style.css').'" rel="stylesheet" media="screen">';
		echo '<link href="'.UtilsHelper::base_url('/css/print.css').'" rel="stylesheet" media="print">';
		
		echo '<!-- Le fav and touch icons -->';
		echo '<link rel="shortcut icon" href="img/favicon.ico">';
		echo '<link rel="apple-touch-icon" href="/img/apple-touch-icon.png">';
		echo '<link rel="apple-touch-icon" sizes="72x72" href="/img/apple-touch-icon-72x72.png">';
		echo '<link rel="apple-touch-icon" sizes="114x114" href="/img/apple-touch-icon-114x114.png">';
		
		echo '<!-- FontAwesome -->';
		echo '<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">';

		echo '<script src="'.UtilsHelper::base_url('/js/jquery.js').'"></script>';
		echo '<script src="'.UtilsHelper::base_url('/js/bootstrap.js').'"></script>';
		echo '<script src="'.UtilsHelper::base_url('/js/sac.js').'"></script>';
	echo '</head>';
	
	echo '<body>';
	
	layoutNavBar();
}

function layoutFooter() {
		echo '<div class="container">';
			echo '<hr>';
			echo '<footer class="footer">';
				echo '<a href="http://fronteiratec.com" target="_blank"><img src="'.UtilsHelper::base_url('/img/logo_fronteiratec_small.png').'"/></a>';
				//echo '<p>&copy; '.date('Y').' - FronteiraTec - Todos os direitos reservados.</p>';
			echo '</footer>';
			
			echo '<div id="info-overlay"></div>';
			
		if(DEBUG_MODE) {
			echo '<div class="row" style="margin-top: 80px;">';
				echo '<div class="span12">';
					echo '<h2>Debug</h2>';
					echo 'IP <pre>'.$_SERVER['REMOTE_ADDR'].'</pre>';
					echo 'Sessão ';
					var_dump($_SESSION);
				echo '</div>';
			echo '</div>';
		}
		echo '</div>';
		
	echo '</body>';
	echo '</html>';
}

function layoutPrintUser($theUserId, $theUserInfo = null, $theSimplified = false) {
	$theUserId = (int)$theUserId;
	$theUserInfo = !isset($theUserInfo) ? User::getById($theUserId) : $theUserInfo;
	
	if ($theUserInfo != null) {
		$aRole = $theUserInfo->type == User::USER_LEVEL_ADMIN ? '<span class="label label-info">Admin</span> ' : '';
		$aAvatar = '<img src="'.(DEBUG_MODE ? '' : 'http://avatars.io/email/'.$theUserInfo->email).'" class="img-circle" title="'.$theUserInfo->name.'" style="'.($theSimplified ? 'width: 25px;' : '').'" />';
		//https://moodle-academico.uffs.edu.br/pluginfile.php/200522/user/icon

		//$aAvatar = '<img src="'.'https://moodle-academico.uffs.edu.br/pluginfile.php/'. $theUserId.'" class="img-circle" title="'.$theUserInfo->name.'" style="'.($theSimplified ? 'width: 25px;' : '').'" />';

		if ($theSimplified) {
			echo '<a href="#">'. $aAvatar . ' ' . $aRole . '<strong>'.$theUserInfo->name.'</strong></a>';
			
		} else {
			echo '<div class="user-info">';
				// TODO: use user data to show profile image
				echo $aAvatar;
				echo '<a href="#"><strong>'.$theUserInfo->name . '</strong></a><br/>';
				echo $aRole;
				
				echo '<small><i class="icon-ok-circle"></i> 10 <i class="icon-briefcase"></i> 3 <i class="icon-fire"></i> 4</small>';
			echo '</div>';
		}
	}
}

?>