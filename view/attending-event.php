<?php 
	use App\Helpers\View;
	
	require_once dirname(__FILE__).'/layout.php';
	
	$aData			= View::data();
	$aUsers			= $aData['users'];
	$aEvent			= $aData['event'];
	$aAttending		= $aData['attending'];
		
	layoutHeader('Gerenciador de pagamento', View::baseUrl());
	
	echo '<div class="jumbotron">';
		echo '<div class="container">';
			echo '<h1>Participantes de Atividade</h1>';
			echo '<p>Lista dos participantes de uma atividade.</p>';
		echo '</div>';
	echo '</div>';
	
	echo '<div class="container">';

		if (isset($aData['createdOrUpdated'])) {
			if ($aData['createdOrUpdated'] == true) {
				echo '<div class="alert alert-success"><strong>Tudo certo!</strong> Operação realizada com sucesso!</div>';
				
			} else {
				echo '<div class="alert alert-danger"><strong>Oops!</strong> Alguma coisa saiu errada.</div>';
			}
		}
	
		echo '<div class="row">';
			echo '<div class="col-md-12">';
				if(count($aUsers) > 0) {
					echo '<div class="panel panel-default item-descriptor">';
						echo '<div class="panel-heading"><strong>'.$aEvent['title'].'</strong></div>';
						echo '<div class="panel-body">';
							echo '<table class="table table-hover">';
								echo '<thead>';
									echo '<th style="width: 5%;"></th>';
									echo '<th style="width: 10%;">Vínculo</th>';
									echo '<th style="width: 45%;">Usuário</th>';
									echo '<th style="width: 20%;">Data da inscrição</th>';
									echo '<th style="width: 10%;">Tudo pago</th>';
									echo '<th style="width: 10%;">Ações</th>';
								echo '</thead>';
								echo '<tbody>';
									$i = 1;
									foreach($aUsers as $aId => $aUser) {
										$aAttendInfo = $aAttending[$aId];
										
										echo '<tr>';
											echo '<td>'.$i++.'</td>';
											echo '<td>'.$aUser['source'].'</td>';
											echo '<td>'.($aUser['admin'] ? '<span class="label label-info">Admin</span> ' : '') . '<a href="mailto:'.$aUser['email'].'"><i class="fa fa-envelope"></i> </a> ' .$aUser['name'].'</td>';
											echo '<td>'.date('d/m/Y', $aAttendInfo['date']).'</td>';
											echo '<td>'.($aUser['paid'] ? '<span class="label label-success">Sim</span>' : '<span class="label label-danger">Não</span>').'</td>';
											echo '<td><a href="attending-event.php?id='.$aEvent['id'].'&remove='.$aId.'" title="Remover usuário dessa atividade"><i class="fa fa-remove"></i> Remover</a></td>';
										echo '</tr>';
									}
								echo '</tbody>';
							echo '</table>';
						echo '</div>';
					echo '</div>';
				} else {
						echo '<div class="alert alert-info" role="alert">Não há inscritos nesso evento <strong>'.$aEvent['title'].'</strong>.</div>';
				}
			echo '</div>';
		echo '</div>';
		
		echo '<div class="row">';
			echo '<div class="col-md-12">';
				echo '<h3>Contato</h3>';
				echo '<p>Abaixo estão listados os e-mails dos usuários inscritos nessa atividade, agrupados pelo status de pagamento da sua inscrição na Semana Acadêmica.</p><br/>';
				
				echo '<div class="panel panel-success item-descriptor">';
					echo '<div class="panel-heading"><strong>Inscrição 100% paga</strong></div>';
					echo '<div class="panel-body">';
						echo '<p>'.(count($aData['emailsPaid']) == 0 ? 'Ninguém' : implode(', ', $aData['emailsPaid'])).'</p>';
					echo '</div>';
				echo '</div>';
				
				echo '<div class="panel panel-danger item-descriptor">';
					echo '<div class="panel-heading"><strong>Inscrição não paga ainda</strong></div>';
					echo '<div class="panel-body">';
						echo '<p>'.(count($aData['emailsNonPaid']) == 0 ? 'Ninguém' : implode(', ', $aData['emailsNonPaid'])).'</p>';
					echo '</div>';
				echo '</div>';
			echo '</div>';
		echo '</div>';
		
	echo '</div>';
	
	layoutFooter(View::baseUrl());
?>