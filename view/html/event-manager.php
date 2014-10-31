<?php 
	require_once dirname(__FILE__).'/layout.php';
	
	$aData	= View::data();
	$aUser 	= $aData['user'];
	$aEvent = $aData['event'];
		
	layoutHeader('Editor de desafios', View::baseUrl());
	
	echo '<div class="jumbotron">';
		echo '<div class="container">';
			echo '<h1>Eventos</h1>';
			echo '<p>Adicionar e editar eventos.</p>';
		echo '</div>';
	echo '</div>';
	
	echo '<div class="container">';
	
	if (isset($aData['createdOrUpdated'])) {
		if ($aData['createdOrUpdated'] == true) {
			echo '<div class="alert alert-success"><strong>Tudo certo!</strong> Evento alterado com sucesso!</div>';
			
		} else {
			echo '<div class="alert alert-danger"><strong>Oops!</strong> Alguma coisa saiu errada.</div>';
		}
	}

	echo '<form action="event-manager.php" method="post" name="formEvent" id="formEvent">';
		echo '<div class="row">';
			echo '<div class="col-md-8">';
				echo '<input type="hidden" name="hasValue" value="1" />';
				echo '<input type="hidden" name="id" value="'.@$aEvent['id'].'" />';
				
				echo '<div class="form-group">';
					echo '<label class="control-label">Título</label>';
					echo '<input type="text" name="title" value="'.@$aEvent['title'].'" class="col-lg-6 form-control" /><br/>';
				echo '</div>';
			echo '</div>';
		echo '</div>';
				
		echo '<div class="row">';		
			echo '<div class="col-md-1">';
				echo '<div class="form-group">';
					echo '<label class="control-label">Dia</label>';
					echo '<input type="text" name="day" value="'.@$aEvent['day'].'" class="col-lg-6 form-control" /><br/>';
				echo '</div>';
			echo '</div>';
			
			echo '<div class="col-md-1">';
				echo '<div class="form-group">';
					echo '<label class="control-label">Mês</label>';
					echo '<input type="text" name="month" value="'.@$aEvent['month'].'" class="col-lg-6 form-control" /><br/>';
				echo '</div>';
			echo '</div>';
			
			echo '<div class="col-md-4">';
				echo '<div class="form-group">';
					echo '<label class="control-label">Horário</label>';
					echo '<input type="text" name="time" value="'.@$aEvent['time'].'" class="col-lg-6 form-control" /><br/>';
				echo '</div>';
			echo '</div>';
			
			echo '<div class="col-md-2">';
				echo '<label class="control-label">Fantasma</label>';
				echo '<select name="ghost" class="form-control col-lg-2">';
					echo '<option value="0" '.(@$aEvent['ghost'] == 0 ? 'selected="selected"' : '').'>Não</option>';
					echo '<option value="1" '.(@$aEvent['ghost'] != 0 ? 'selected="selected"' : '').'>Sim</option>';
				echo '</select>';
			echo '</div>';
		echo '</div>';			
		
		echo '<div class="row">';
			echo '<div class="col-md-6">';
				echo '<div class="form-group">';
					echo '<label class="control-label">Local</label>';
					echo '<input type="text" name="place" value="'.@$aEvent['place'].'" class="col-lg-6 form-control" /><br/>';
				echo '</div>';
			echo '</div>';
			
			echo '<div class="col-md-2">';
				echo '<div class="form-group">';
					echo '<label class="control-label">Custo</label>';
					echo '<input type="text" name="price" value="'.@$aEvent['price'].'" class="col-lg-6 form-control" /><br/>';
				echo '</div>';
			echo '</div>';
		echo '</div>';
			
		echo '<div class="row">';
			echo '<div class="col-md-2">';
				echo '<div class="form-group">';
					echo '<label class="control-label">Vagas</label>';
					echo '<input type="text" name="capacity" value="'.@$aEvent['capacity'].'" class="col-lg-6 form-control" /><br/>';
				echo '</div>';
			echo '</div>';
			
			echo '<div class="col-md-2">';
				echo '<div class="form-group">';
					echo '<label class="control-label">Vagas (espera)</label>';
					echo '<input type="text" name="waiting_capacity" value="'.@$aEvent['waiting_capacity'].'" class="col-lg-6 form-control" />';
				echo '</div>';
			echo '</div>';

			echo '<div class="col-md-4">';
				echo '<label class="control-label">Competição?</label>';
				echo '<select name="fk_competition" class="form-control col-lg-2">';
					echo '<option value=""></option>';
					foreach($aData['competitions'] as $aIdCompetition => $aInfoCompetition) {
						echo '<option value="'.$aIdCompetition.'" '.(@$aEvent['fk_competition'] == $aIdCompetition ? 'selected="selected"' : '').'>'.$aInfoCompetition['title'].'</option>';
					}
				echo '</select>';
			echo '</div>';
		echo '</div>';
		
		echo '<div class="row">';
			echo '<div class="col-md-8">';
				echo '<div class="form-group">';
					echo '<label class="control-label">Descrição</label>';
					echo '<textarea name="description" class="col-lg-6 form-control" style="height: 300px;" />'.@$aEvent['description'].'</textarea>';
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