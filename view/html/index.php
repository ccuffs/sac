<?php 
	require_once dirname(__FILE__).'/layout.php';
	
	layoutHeader('Programação', View::baseUrl());
	
	$aData 			= View::data();
	$aEvents 		= $aData['events'];
	$aAttending 	= $aData['authenticated'] ? $aData['attending'] : array();
	$aIsAdmin 		= $aData['isAdmin'];

	echo '<div class="container schedule">';
		echo '<div class="row">';
				echo '<div class="col-md-12" style="text-align: center;">';
					echo '<img src="'.View::baseUrl().'/img/sac.png" />';
				echo '</div>';
		echo '</div>';
	echo '</div>';
	
	if($aData['authenticated']) {
		echo '<div class="container">';
			echo '<div class="row">';
				echo '<div class="col-md-12" id="payment-panel">';
				echo '</div>';
			echo '</div>';
		echo '</div>';
	}

	echo '<div class="container">';
		echo '<div class="row">';
			echo '<div class="col-md-12">';
				foreach($aEvents as $aDate => $aList) {
					echo '<div class="panel panel-default item-descriptor">';
						echo '<div class="panel-heading"><strong>'.$aDate.'</strong></div>';
						echo '<div class="panel-body">';
							echo '<table class="table table-hover event-schedule">';
								echo '<thead>';
									echo '<th>Horário</th>';
									echo '<th>Atividade</th>';
									echo '<th>Local</th>';
									echo '<th>Custo</th>';
									echo '<th>Vagas</th>';
									
									if($aData['authenticated']) {
										echo '<th style="width: 10%; text-align: center;">Participar</th>';
									}
								echo '</thead>';
								echo '<tbody>';
									foreach($aList as $aIdEvent => $aInfo) {
										echo '<tr>';
											echo '<td>'.$aInfo['time'].'</td>';
											echo '<td><strong>'.$aInfo['title'].'</strong>'.($aIsAdmin ? ' <a href="event-manager.php?id='.$aIdEvent.'" title="Editar evento"><i class="fa fa-edit"></i></a> <a href="attending-event.php?id='.$aIdEvent.'" title="Listar as pessoas que estão inscritas para essa atividade"><i class="fa fa-group"></i></a>' : '').'<br/><p class="event-description">'.$aInfo['description'].'</p></td>';
											echo '<td>'.$aInfo['place'].'</td>';
											echo '<td>'.($aInfo['price'] > 0 ? 'R$ ' . $aInfo['price'] : '-').'</td>';
											echo '<td>'.($aInfo['capacity'] != 0 ? $aInfo['capacity'] : '-').'</td>';
											
											if ($aData['authenticated']) {
												echo '<td id="panel-event-'.$aIdEvent.'" style="text-align: center;" class="panel-event">';
													if (is_numeric($aInfo['fk_competition'])) {
														echo '<a href="competition.php?competition='.$aInfo['fk_competition'].'"><i class="fa fa-info-circle"></i> Infos</a> '.($aIsAdmin ? ' <a href="competition-manager.php?id='.$aInfo['fk_competition'].'"><i class="fa fa-edit"></i></a> ' : '');
														
													} else if($aInfo['ghost'] == 0){
														if (isset($aAttending[$aIdEvent])) {
															echo '<span class="label label-success"><i class="fa fa-check-square"></i> Inscrito</span>';
															echo ' <a href="javascript:void(0);" onclick="SAC.unsubscribe('.$aIdEvent.')" title="Clique para remover sua inscrição dessa atividade."><i class="fa fa-remove"></i></a>';
														} else {
															echo '<a href="javascript:void(0);" onclick="SAC.subscribe('.$aIdEvent.', '.($aInfo['capacity'] != 0 ? 'true' : 'false').')" title="Clique para se inscrever nessa atividade."><i class="fa fa-square-o"></i></a>';
														}
													} else {
														echo '-';
													}
												echo '</td>';
											}
										echo '</tr>';
									}
								echo '</tbody>';
							echo '</table>';
						echo '</div>';
					echo '</div>';
				}
			echo '</div>';
		echo '</div>';
	echo '</div>';
	
	echo '<div class="container footer-partners" style="margin-top: 30px;">';
		echo '<div class="row">';
				echo '<div class="col-md-4">';
					echo '<p><strong>Realização:</strong></p>';
				echo '</div>';
				echo '<div class="col-md-8">';
					echo '<p><strong>Apoio:</strong></p>';
				echo '</div>';
		echo '</div>';
		echo '<div class="row">';
			echo '<div class="col-md-2 staff-logo">';
				echo '<a href="http://cc.uffs.edu.br" target="_blank"><img src="'.View::baseUrl().'/img/ca.png" border="0" /></a>';
				echo '<a href="http://cc.uffs.edu.br" target="_blank"><img src="'.View::baseUrl().'/img/logo_cc.png" border="0" /></a>';
			echo '</div>';
			echo '<div class="col-md-1 staff-logo">';
				echo '<a href="http://www.uffs.edu.br" target="_blank"><img src="'.View::baseUrl().'/img/uffs.png" class="logo-uffs" border="0" /></a>';
			echo '</div>';
			echo '<div class="col-md-1 staff-logo">';
			echo '</div>';
			
			echo '<div class="col-md-5 partner-logo">';
				echo '<a href="http://stmaria.com.br" target="_blank"><img src="'.View::baseUrl().'/img/santamaria.jpg" class="logo-santamaria" border="0" /></a>';
			echo '</div>';
			echo '<div class="col-md-3">';
				echo '<a href="https://www.facebook.com/GAMDIASGAMING.BR" target="_blank"><img src="'.View::baseUrl().'/img/gambdias_small.png" class="logo-gambdias" border="0" /></a><br/>';
				echo '<a href="http://fronteiratec.com" target="_blank"><img src="'.View::baseUrl().'/img/fronteiratec.png" class="logo-fronteiratec" /></a>';
				echo '<a href="http://www.donsini.com.br/" target="_blank"><img src="'.View::baseUrl().'/img/donsini.jpg" class="logo-donsini" /></a>';
				echo '<img src="'.View::baseUrl().'/img/tomray.jpg" class="logo-tomray" />';
			echo '</div>';
		echo '</div>';
	echo '</div>';
	
	echo "<script>SAC.loadPaymentInfo('payment-panel');</script>";
	
	layoutFooter(View::baseUrl());
?>