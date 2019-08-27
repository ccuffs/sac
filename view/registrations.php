<?php 
	require_once dirname(__FILE__).'/layout.php';

	use \core\View;
	
	layoutHeader('Cadastros', View::baseUrl());
	
	$aData 	= View::data();
	$aUsers = $aData['users'];

	echo '<div class="jumbotron">';
		echo '<div class="container">';
			echo '<h1>Cadastros</h1>';
			echo '<p>Lista de participantes do evento.</p>';
		echo '</div>';
	echo '</div>';
	
	echo '<div class="container">';
		echo '<div class="row">';
			echo '<div class="col-md-12">';
				echo '<div class="panel panel-default item-descriptor">';
					echo '<div class="panel-heading"><strong>Informações</strong></div>';
					echo '<div class="panel-body dashboard-registration">';
						echo '<p><strong>R$ '.sprintf('%0.2f', $aData['total_paid']).'</strong><br/>Total pago</p>';
						echo '<p><strong>'.$aData['users_paid_total'].'</strong><br/>Pagantes</p>';
						echo '<p><strong>'.$aData['users_nonpaid_total'].'</strong><br/>Não pagantes</p>';
						echo '<p><strong>'.$aData['users_insiders'].'</strong><br/>Inscritos UFFS</p>';
						echo '<p><strong>'.$aData['users_outsiders'].'</strong><br/>Inscritos Externos</p>';
					echo '</div>';
				echo '</div>';
			echo '</div>';
		echo '</div>';
		
		echo '<div class="row">';
			echo '<div class="col-md-12">';
				echo '<div class="panel panel-default item-descriptor">';
					echo '<div class="panel-heading"><strong>Inscritos</strong></div>';
					echo '<div class="panel-body">';
						echo '<table class="table table-hover">';
							echo '<thead>';
								echo '<th style="width: 40%;">Nome</th>';
								echo '<th style="width: 25%;">CPF</th>';
								echo '<th style="width: 25%;">E-mail</th>';
								echo '<th style="width: 5%;">Vínculo</th>';
								echo '<th style="width: 5%;">Pagou?</th>';

							echo '</thead>';
							echo '<tbody>';
								foreach($aUsers as $aId => $aInfo) {
									echo '<tr>';
										echo '<td>'.($aInfo['admin'] ? '<span class="label label-info">Admin</span> ' : '') . $aInfo['name'].'</td>';
										echo '<td>'.$aInfo['login'].'</td>';
										echo '<td>'.$aInfo['email'].'</td>';
										echo '<td>'.$aInfo['source'].'</td>';
										echo '<td>';
											if ($aInfo['paid']) {
												echo '<span class="label label-success">Sim R$ '.sprintf('%.2f', $aInfo['paid_credit']).'</span>';
												
											} else if ($aInfo['paid_credit'] > 0) {
												echo '<span class="label label-warning">Parcial R$ '.sprintf('%.2f', $aInfo['paid_credit']).'</span>';
												
											} else if ($aInfo['no_payment']) {
												echo '<span class="label label-primary">Nada</span>';
												
											} else {
												echo '<span class="label label-danger">Não</span>';
											}
										'</td>';
									echo '</tr>';
								}
							echo '</tbody>';
						echo '</table>';
					echo '</div>';
				echo '</div>';
			echo '</div>';
		echo '</div>';
	echo '</div>';
	
	layoutFooter(View::baseUrl());
?>