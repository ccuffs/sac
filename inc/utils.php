<?php

function utilMonthToString($theMonth) {
	$aMonths = array(
		1 => 'Janeiro',
		2 => 'Fevereiro',
		3 => 'Março',
		4 => 'Abril',
		5 => 'Maio',
		6 => 'Junho',
		7 => 'Julho',
		8 => 'Agosto',
		9 => 'Setembro',
		10 => 'Outrubro',
		11 => 'Novembro',
		12 => 'Dezembro'
	);
	return isset($aMonths[$theMonth]) ? $aMonths[$theMonth] : '?';
}

function utilOut($theScript) {
	return htmlentities($theScript);
}

?>