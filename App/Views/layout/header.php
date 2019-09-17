<?php 
use App\Helpers\View;
use App\Helpers\UtilsHelper;
use App\Helpers\AuthHelper;
use App\Models\User;
?>

<!DOCTYPE html>
	<html lang="en">
	<head>
		<meta charset="utf-8">
		<title> Semana Acadêmica Ciência da Computação - 17 a 21 de outubro de 2014</title>
		<meta name="description" content="">
		<meta name="author" content="">
		
		<!-- Le HTML5 shim, for IE6-8 support of HTML elements -->
		<!--[if lt IE 9]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
		
		<!-- Le styles -->
		<link href="<?= UtilsHelper::base_url('/css/bootstrap.min.css') ?>" rel="stylesheet">
		<link href="<?= UtilsHelper::base_url('/css/style.css') ?>" rel="stylesheet" media="screen">
		<link href="<?= UtilsHelper::base_url('/css/print.css') ?>" rel="stylesheet" media="print">
		
		<!-- Le fav and touch icons -->
		<link rel="shortcut icon" href="img/favicon.ico">
		<link rel="apple-touch-icon" href="/img/apple-touch-icon.png">
		<link rel="apple-touch-icon" sizes="72x72" href="/img/apple-touch-icon-72x72.png">
		<link rel="apple-touch-icon" sizes="114x114" href="/img/apple-touch-icon-114x114.png">
		
		<!-- FontAwesome -->
		<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
		
		<script src="<?= UtilsHelper::base_url('/js/jquery.js') ?>"></script>
		<script src="<?= UtilsHelper::base_url('/js/bootstrap.js') ?>"></script>
		<script src="<?= UtilsHelper::base_url('/js/sac.js') ?>"></script>
	</head>
	
	<body>

	<nav class="navbar navbar-default" role="navigation">
		<div class="container">
			<div class="navbar-header">
				<a class="navbar-brand" href="<?= UtilsHelper::base_url("/") ?>" title="Ir para página inicial"><i class="fa fa-calendar"/></i> Programação</a>
			</div>
			
			<div class="collapse navbar-collapse">
				<ul class="nav navbar-nav navbar-right">
					<?php if (isset($user)): ?>
						<li style="margin-top: -5px;">
							<a href="#">
							<img src="<?= 'http://avatars.io/email/'.$user->email ?>" class="img-circle" title="<?= $user->name ?>" style="width: 25px;"/>
							<?= $user->isLevel(User::USER_LEVEL_ADMIN) ? '<span class="label label-info">Admin</span>' : '' ?>
								<strong><?= $user->name ?></strong></a>
						</li>

						<li class="dropdown">
							<a class="dropdown-toggle" data-toggle="dropdown" href="#"><b class="caret"></b></a>
							<ul class="dropdown-menu" role="menu">
							<li><a href="<?= UtilsHelper::base_url("/logout")?>"><i class="fa fa-sign-out"></i> Sair</a></li>
							</ul>
						</li>
					<?php else: ?> 
						<li class="dropdown">
							<a role="button" class="btn btn-info" style="margin-top: 7px;">
								<span class="fa fa-user"></span> Inscrever-se
							</a> 
							<a href="<?= UtilsHelper::base_url("/login")?>" role="button" class="btn btn-success" style="margin-top: 7px;">
								<span class="fa fa-user"></span> Login
							</a>
						</li>
					<?php endif; ?>
				</ul>
					
				<?php if(isset($user) && $user->isLevel(User::USER_LEVEL_ADMIN)): ?>
					<ul class="nav navbar-nav navbar-right">
						<li class="dropdown">
							<a class="dropdown-toggle" data-toggle="dropdown" href="#">Ações <b class="caret"></b></a>
							<ul class="dropdown-menu" role="menu">
								<li role="presentation" class="dropdown-header">Programação</li>
								<li><a href="<?= UtilsHelper::base_url("/admin/evento")?>">Eventos</a></li>
								<li><a href="<?= UtilsHelper::base_url("/admin/campeonato")?>">Criar campeonato</a></li>
							
								<li class="divider"></li>
								<li role="presentation" class="dropdown-header">Inscrições</li>
								<li><a href="<?= UtilsHelper::base_url("/admin/inscricoes")?>">Listar</a></li>
								<li><a href="<?= UtilsHelper::base_url("/admin/pagamento")?>">Pagamentos</a></li>
							
								<li class="divider"></li>
								<li role="presentation" class="dropdown-header">Frequência</li>
								<li><a href="javascript:void(0);">Gerenciar</a></li>
							</ul>
						</li>
					</ul>
				<?php endif; ?>
			</div>
		</div>
	</nav>