<?php 
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
		echo '<div class="row">';
			echo '<div class="col-md-12">';
				if(count($aUsers) > 0) {
					echo '<div class="panel panel-default item-descriptor">';
						echo '<div class="panel-heading"><strong>'.$aEvent['title'].'</strong></div>';
						echo '<div class="panel-body">';
							echo '<table class="table table-hover">';
								echo '<thead>';
									echo '<th style="width: 5%;"></th>';
									echo '<th style="width: 5%;">Vínculo</th>';
									echo '<th style="width: 35%;">Usuário</th>';
									echo '<th style="width: 10%;">Data da inscrição</th>';
									echo '<th style="width: 10%;"></th>';
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
											echo '<td></td>';
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
	
	echo '</div>';
	
	layoutFooter(View::baseUrl());
?>