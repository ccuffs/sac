<?php 
	require_once dirname(__FILE__).'/layout.php';
	
	$aData			= View::data();
	$aUsers			= $aData['users'];
	$aPayments 		= $aData['payments'];
		
	layoutHeader('Gerenciador de pagamento', View::baseUrl());
	
	echo '<div class="jumbotron">';
		echo '<div class="container">';
			echo '<h1>Pagamentos</h1>';
			echo '<p>Adicionar ou remover pagamentos de usuários.</p>';
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

	echo '<form action="payment-manager.php" method="post" name="formPayment" id="formPayment">';
		echo '<input type="hidden" name="addEntry" value="1" />';
		
		echo '<div class="row">';
			echo '<div class="col-md-4">';
				echo '<div class="form-group">';
					echo '<label class="control-label">Usuário</label>';
					echo '<select name="fk_user" class="col-lg-6 form-control">';
						echo '<option value=""></option>';
						foreach($aUsers as $aIdUser => $aUser) {
							echo '<option value="'.$aIdUser.'">'.utilOut($aUser['name']).'</option>';
						}
					echo '</select>';
				echo '</div>';
			echo '</div>';
		
			echo '<div class="col-md-2">';
				echo '<input type="hidden" name="hasValue" value="1" />';
				
				echo '<div class="form-group">';
					echo '<label class="control-label">Valor</label>';
					echo '<input type="text" name="amount" class="col-lg-6 form-control" /><br/>';
				echo '</div>';
			echo '</div>';
			
			echo '<div class="col-md-4">';
				echo '<div class="form-group">';
					echo '<label class="control-label">Comentário</label>';
					echo '<input type="text" name="comment" class="col-lg-6 form-control" /><br/>';
				echo '</div>';
			echo '</div>';
			
			echo '<div class="col-md-1">';
				echo '<div class="form-group">';
				echo '<label class="control-label"></label>';
					echo '<input type="submit" name="submit" value="Adicionar pagamento" class="btn btn-success" />';
				echo '</div>';
			echo '</div>';
		echo '</div>';
	echo '</form>';
	
	echo '<div class="row" style="margin-top: 50px;">';
		echo '<div class="col-md-12">';
			echo '<div class="panel panel-default item-descriptor">';
				echo '<div class="panel-heading"><strong>Pagamentos</strong></div>';
				echo '<div class="panel-body">';
					echo '<table class="table table-hover">';
						echo '<thead>';
							echo '<th style="width: 5%;">Vínculo</th>';
							echo '<th style="width: 35%;">Usuário</th>';
							echo '<th style="width: 20%;">CPF</th>';
							echo '<th style="width: 10%;">Data</th>';
							echo '<th style="width: 17%;">Comentário</th>';							
							echo '<th style="width: 10%;">Valor</th>';							
							echo '<th style="width: 3%;"></th>';

						echo '</thead>';
						echo '<tbody>';
							foreach($aPayments as $aId => $aInfo) {
								$aUser = $aUsers[$aInfo['fk_user']];
								
								echo '<tr>';
									echo '<td>'.$aUser['source'].'</td>';
									echo '<td>'.($aUser['admin'] ? '<span class="label label-info">Admin</span> ' : '') . '<a href="mailto:'.$aUser['email'].'"><i class="fa fa-envelope"></i> </a> ' .$aUser['name'].'</td>';
									echo '<td>'.$aUser['login'].'</td>';
									echo '<td>'.date('d/m/Y', $aInfo['date']).'</td>';
									echo '<td>'.$aInfo['comment'].'</td>';
									echo '<td>R$ '.sprintf('%.2f', $aInfo['amount']).'</td>';
									echo '<td><a href="javascript:void(0)" onclick="SAC.deletePayment('.$aInfo['id'].');" title="Apagar pagamento"><i class="fa fa-trash-o"></i></a></td>';
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