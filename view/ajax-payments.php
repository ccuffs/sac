<?php 

use \core\View;

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
		echo '<strong>Inscrição em andamento!</strong><br/>O valor que você terá que pagar para a inscrição está sendo analisado pela organização. Por favor, aguarde até que ele seja definido.<br/>';
		
		if (isset($aPayments)) {
			foreach($aPayments as $aId => $aInfo) {
				echo '<i class="fa fa-calendar"></i> ' . date('d/m/Y').' ';
				echo '<strong> &nbsp;&nbsp;&nbsp;&nbsp; R$ ';
				printf('%.2f', $aInfo['amount']);
				echo '</strong> &nbsp;&nbsp;&nbsp;&nbsp; <em> '.paymentStatusToString($aInfo['status']).'</em>.<br/>';
			}
		}
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
		
		echo '<strong>IMPORTANTE:</strong> Envie o comprovante da operação por e-mail para <a href="cacomputacaouffs@gmail.com">cacomputacaouffs@gmail.com</a>. ';
		echo 'O pagamento também pode ser feito em mãos com os seguintes representantes do CA: <strong> Aline Menin, Doglas André Finco, Dinara Rigon ou Mario Urlich </strong>.';
	echo '</div>';
}

?>