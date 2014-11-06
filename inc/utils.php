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

function utilWeekDayToString($theDay, $theMonth) {
	$aDay = date('N', mktime(0, 0, 0, $theMonth, $theDay, date('Y')));
	
	$aWeek = array(
		1 => 'segunda-feira',
		2 => 'terça-feira',
		3 => 'quarta-feira',
		4 => 'quinta-feira',
		5 => 'sexta-feira',
		6 => 'sábado',
		7 => 'domingo'
	);
	return isset($aWeek[$aDay]) ? $aWeek[$aDay] : '?';
}

function utilOut($theScript) {
	return htmlentities($theScript);
}

?>