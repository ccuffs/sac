<?php 
require_once dirname(__FILE__).'/layout.php';

authAllowAuthenticated();

$aData 			= View::data();
$aDept 			= @$aData['dept'];
$aPayments		= @$aData['payments'];

header('Content-Type: text/html; charset=utf-8');

if($aData['noDept']) {
	echo '<div class="alert alert-success" role="alert">';
		echo '<strong>Inscrição confirmada!</strong><br/> Sua inscrição já foi paga e está confirmada. Bom evento!';
	echo '</div>';
	
} else if ($aData['beingAnalyzed']) {
	echo '<div class="alert alert-warning" role="alert">';
		echo '<strong>Pagamento em andamento!</strong><br/><br/> Estamos aguardando o seu pagamento ou ele está sendo analisado pela organização. <br/>';
		
		if (isset($aPayments)) {
			echo 'Abaixo estão seus pagamentos e o status de cada um: <br/><br/>';
			
			foreach($aPayments as $aId => $aInfo) {
				echo '<i class="fa fa-calendar"></i> ' . date('d/m/Y').' ';
				echo '<strong> &nbsp;&nbsp;&nbsp;&nbsp; R$ ';
				printf('%.2f', $aInfo['amount']);
				echo '</strong> &nbsp;&nbsp;&nbsp;&nbsp; <em> '.paymentStatusToString($aInfo['status']).'</em>.<br/>';
			}
		}
		echo '<br/>';
		echo '<button onclick="window.location=\'pay.php\'" class="btn btn-warning" style="position: absolute; top: 20px; right: 30px;">Pagar com PagSeguro</button>';
	echo '</div>';
} else {
	echo '<div class="alert alert-danger" role="alert">';
		echo '<strong>Inscrição pendente!</strong><br/>';
		echo 'Sua inscrição ainda não foi paga. Você precisa pagar <strong>R$ ';
		printf('%.2f', $aDept);
		echo '</strong> para participar do evento. ';
		
		echo 'Abaixo estão os dados da conta para pagamento: <br/><br/>';
		echo '<strong>';
			echo 'Banco do Brasil <br/>';
			echo 'Agência: 3004-X<br/>';
			echo 'Conta: 21.680-1<br/>';
			echo 'Titular: Doglas André Finco<br/>';
		echo '</strong><br/>';
		
		echo 'O pagamento também pode ser feito em mãos com os seguintes representantes do CA: <strong>Aline Menin, Doglas André Finco, Dinara Rigon ou Mario Urlich</strong>.<br/>';
	echo '</div>';
}

?>