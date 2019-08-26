<?php 
	require_once dirname(__FILE__).'/layout.php';
	
	$aData			= View::data();
	$aUser 			= $aData['user'];
	$aCompetition 	= $aData['competition'];
		
	layoutHeader('Editor de competição', View::baseUrl());
	
	echo '<div class="jumbotron">';
		echo '<div class="container">';
			echo '<h1>Competição</h1>';
			echo '<p>Adicionar e editar competições.</p>';
		echo '</div>';
	echo '</div>';
	
	echo '<div class="container">';
	
	if (isset($aData['createdOrUpdated'])) {
		if ($aData['createdOrUpdated'] == true) {
			echo '<div class="alert alert-success"><strong>Tudo certo!</strong> Competição alterada com sucesso!</div>';
			
		} else {
			echo '<div class="alert alert-danger"><strong>Oops!</strong> Alguma coisa saiu errada.</div>';
		}
	}

	echo '<form action="competition-manager.php" method="post" name="formCompetition" id="formCompetition">';
		echo '<div class="row">';
			echo '<div class="col-md-12">';
				echo '<input type="hidden" name="hasValue" value="1" />';
				echo '<input type="hidden" name="id" value="'.@$aCompetition['id'].'" />';
				
				echo '<div class="form-group">';
					echo '<label class="control-label">Título</label>';
					echo '<input type="text" name="title" value="'.@$aCompetition['title'].'" class="col-lg-6 form-control" /><br/>';
				echo '</div>';
			echo '</div>';
		echo '</div>';
		
		echo '<div class="row">';
			echo '<div class="col-md-12">';
				echo '<div class="form-group">';
					echo '<label class="control-label">Headline</label>';
					echo '<input type="text" name="headline" value="'.@$aCompetition['headline'].'" class="col-lg-6 form-control" /><br/>';
				echo '</div>';
			echo '</div>';
		echo '</div>';
		
		echo '<div class="row">';
			echo '<div class="col-md-12">';
				echo '<div class="form-group">';
					echo '<label class="control-label">CSS Cabeçalho</label>';
					echo '<input type="text" name="style" value="'.@$aCompetition['style'].'" class="col-lg-6 form-control" /><br/>';
				echo '</div>';
			echo '</div>';
		echo '</div>';
				
		echo '<div class="row">';
			echo '<div class="col-md-12">';
				echo '<div class="form-group">';
					echo '<label class="control-label">Descrição</label>';
					echo '<textarea name="description" class="col-lg-6 form-control" style="height: 300px;" />'.@$aCompetition['description'].'</textarea>';
				echo '</div>';
			echo '</div>';
		echo '</div>';
		
		echo '<div class="row">';
			echo '<div class="col-md-12">';
				echo '<div class="form-group">';
					echo '<label class="control-label">Premiação</label>';
					echo '<textarea name="prizes" class="col-lg-6 form-control" style="height: 300px;" />'.@$aCompetition['prizes'].'</textarea>';
				echo '</div>';
			echo '</div>';
		echo '</div>';
		
		echo '<div class="row">';
			echo '<div class="col-md-12">';
				echo '<div class="form-group">';
					echo '<label class="control-label">Regulamento</label>';
					echo '<textarea name="rules" class="col-lg-6 form-control" style="height: 300px;" />'.@$aCompetition['rules'].'</textarea>';
				echo '</div>';
			echo '</div>';
		echo '</div>';
		
		echo '<div class="row" style="margin-top: 15px;">';
			echo '<div class="col-md-12">';
				echo '<input type="submit" name="submit" value="Salvar" class="btn btn-success" />';
			echo '</div>';
		echo '</div>';
	echo '</form>';
	
	echo '</div>';
	
	layoutFooter(View::baseUrl());
?>