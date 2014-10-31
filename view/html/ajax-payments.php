<?php 
require_once dirname(__FILE__).'/layout.php';

authAllowAuthenticated();

$aData 			= View::data();
$aDept 			= @$aData['dept'];
$aPayments		= @$aData['payments'];

header('Content-Type: text/html; charset=utf-8');

if ($aDept > 0) {
	// Devendo...
	echo '<div class="alert alert-danger" role="alert">';
		echo '<strong>Pagamento pendente!</strong><br/>';
		echo 'Sua inscrição ainda não foi paga. Você precisa pagar <strong>R$ ';
		printf('%.2f', $aDept);
		echo '</strong> para participar do evento.';
		
		if (!isset($aPayments)) {
			echo '<button onclick="window.location=\'pay.php\'" class="btn btn-danger" style="position: absolute; top: 20px; right: 30px;">Pagar com PagSeguro</button>';
		}
	
} else {
	echo '<div class="alert alert-success" role="alert">';
			echo '<strong>Inscrição paga!</strong><br/> Sua inscrição já foi paga.';
}

if (isset($aPayments)) {
	echo '<br/>Abaixo estão seus pagamentos e o status de cada um: <br/><br/>';
	
	foreach($aPayments as $aId => $aInfo) {
		echo '<i class="fa fa-calendar"></i> ' . date('d/m/Y').' ';
		echo '<strong> &nbsp;&nbsp;&nbsp;&nbsp; R$ ';
		printf('%.2f', $aInfo['amount']);
		echo '</strong> &nbsp;&nbsp;&nbsp;&nbsp; <em> '.paymentStatusToString($aInfo['status']).'</em>.<br/>';
	}
}

echo '</div>';

?>