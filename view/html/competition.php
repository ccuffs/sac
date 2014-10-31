<?php 
	require_once dirname(__FILE__).'/layout.php';
	
	layoutHeader('Login', View::baseUrl());
	
	$aData 			= View::data();
	$aCompetition	= $aData['competition'];
	$aTeams			= $aData['teams'];
	$aTeam			= $aData['team'];
	$aAuthenticated	= $aData['authenticated'];
	$aCompetitors	= $aData['competitors'];
	$aIsAdmin		= $aData['isAdmin'];
	
	echo '<div class="jumbotron competition">';
		echo '<div class="container" style="'.$aCompetition['style'].'">';
			echo '<h1>'.$aCompetition['title'].'</h1>';
			echo '<p>'.$aCompetition['headline'].'</p>';
		echo '</div>';
	echo '</div>';
	
	echo '<div class="container competition-page">';
		if ($aIsAdmin) {
			echo '<div class="row">';
				echo '<div class="col-md-12">';
					echo '<a href="competition-manager.php?id='.$aCompetition['id'].'" class=" pull-right"><i class="fa fa-edit"></i> Editar competição</a>';
				echo '</div>';
			echo '</div>';
		}
	
		if($aCompetition['description'] != '') {
			echo '<div class="row">';
				echo '<div class="col-md-12">';
					echo '<h2>Descrição</h2>';
					echo $aCompetition['description'];
				echo '</div>';
			echo '</div>';
		}

		if($aCompetition['prizes'] != '') {
			echo '<div class="row">';
				echo '<div class="col-md-12">';
					echo '<h2>Premiação</h2>';
					echo $aCompetition['prizes'];
				echo '</div>';
			echo '</div>';
		}
		
		echo '<div class="row">';
			echo '<div class="col-md-12">';
				echo '<h2>Times</h2>';
				if($aTeam == null) {
					echo '<div class="alert alert-warning" role="alert">Se você é capitação de algum tipe, clique no botão ao lado para cadastrar seu time. <button class="btn btn-default pull-right" style="margin-top: -5px;">Cadastrar time</button></div>';
				} else {
					echo '<form action="competition.php?competition='.$aCompetition['id'].'" name="form-team" method="post" role="form">';
						echo '<div class="panel panel-'.($aTeam['paid'] ? 'success' : 'danger').'">';
							echo '<div class="panel-heading">';
								echo '<strong>Informações sobre o seu time</strong>';
								echo '<p class="pull-right">'.($aTeam['paid'] ? '<strong>A inscrição do time foi paga! Só competir <i class="fa fa-thumbs-o-up"></i></strong>' : '<strong><i class="fa fa-warning"></i> A inscrição do time não foi paga ainda! Fale com a organização.</strong>').'</p>';
							echo '</div>';
								
							echo '<div class="panel-body">';
								echo '<input type="hidden" name="id" value="'.@$aTeam['id'].'" />';
								echo '<input type="hidden" name="register" value="1" />';
								
								echo '<div class="form-group">';
									echo '<label for="name">Nome</label>';
									echo '<input type="name" class="form-control" id="name" name="name" placeholder="Nome do seu time (ex.: Os Vingadores)" value="'.@$aTeam['name'].'">';
								echo '</div>';
								
								echo '<div class="form-group">';
									echo '<label for="url">Bandeira</label>';
									echo '<input type="text" class="form-control" id="url" name="url" placeholder="http://www.site.com/img.jpg" value="'.@$aTeam['url'].'">';
								echo '</div>';
								
								echo '<table class="table table-hover">';
									echo '<thead>';
										echo '<th>Integrantes</th>';
									echo '</thead>';
									echo '<tbody>';
										for ($i = 0; $i < 5; $i++) {
											echo '<tr>';
												echo '<td>';
													echo '<select name="member'.$i.'">';
														echo '<option value=""></option>';
														foreach($aCompetitors as $aIdUser => $aUser) {
															echo '<option value="'.$aIdUser.'" '.($aTeam['members'][$i] == $aIdUser ? 'selected="selected"' : '').'>'.utilOut($aUser['name']).'</option>';
														}
													echo '</select>';
												echo '</td>';
											echo '</tr>';
										}
									echo '</tbody>';
								echo '</table>';
							echo '</div>';
							echo '<div class="panel-footer">';
								echo '<button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Salvar</button>';
								//echo '<button class="btn btn-danger pull-right"><i class="fa fa-trash"></i> Apagar time</button>';
							echo '</div>';
						echo '</div>';
					echo '</form>';
				}
			echo '</div>';
		echo '</div>';
		
		echo '<div class="row">';
			$aCount = count($aTeams);
			
			if ($aCount == 0) {
				echo 'Não há times cadastrados no momento.';
			} else {
				foreach($aTeams as $aIdTeam => $aInfoTeam) {
					echo '<div class="col-md-3">';
						echo '<div class="thumbnail team">';
							echo '<img src="'.($aInfoTeam['url'] == '' ? View::baseUrl().'/img/avatar.png' : utilOut($aInfoTeam['url'])).'" alt="'.utilOut($aInfoTeam['name']).'">';
							echo '<div class="caption">';
								echo '<h3>'.($aInfoTeam['paid'] ? '<i class="fa fa-check-circle" title="Inscrição confirmada!"></i>' : '').' '.utilOut($aInfoTeam['name']).'</h3>';
								
								$aMembers = unserialize($aInfoTeam['members']);
								
								if ($aMembers !== false) {
									echo '<div class="list-group">';
										foreach($aMembers as $aMember) {
											if($aMember != '') {
												echo '<p class="list-group-item"><i class="fa fa-user"></i> '.utilOut($aCompetitors[$aMember]['name']).'</p>';
											}
										}
									echo '</div>';
								}
							echo '</div>';
						echo '</div>';
					echo '</div>';
				}
			}
		echo '</div>';
		
		if($aCompetition['rules'] != '') {
			echo '<div class="row">';
				echo '<div class="col-md-12">';
					echo '<h2>Regulamento</h2>';
					echo $aCompetition['rules'];
				echo '</div>';
			echo '</div>';
		}
	echo '</div>';
	
	layoutFooter(View::baseUrl());
?>