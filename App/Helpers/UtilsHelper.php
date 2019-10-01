<?php

namespace App\Helpers;

class UtilsHelper {
	public static function monthToString($theMonth) {
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
	
	public static function weekDayToString($theDay, $theMonth) {
		$aDay = date('N', mktime(0, 0, 0, $theMonth, $theDay, date('Y')));
		
		$aWeek = array(
			1 => 'Segunda',
			2 => 'Terça',
			3 => 'Quarta',
			4 => 'Quinta',
			5 => 'Sexta',
			6 => 'Sábado',
			7 => 'Domingo'
		);
		return isset($aWeek[$aDay]) ? $aWeek[$aDay] : '?';
	}

	/*public static function getWeekDay($date) {
		return date('w', strtotime($date));
	}*/
	
	public static function out($theScript) {
		return htmlspecialchars($theScript, ENT_QUOTES, "UTF-8");
	}
	
	public static function base_url($url = "") {
		/* TODO: Config this */
		return BASE_URL . $url;
	}

	public function format_money($money){
        return str_replace('R$', '', str_replace(',', '.', $money));
	}
	
	public function format_cpf($cpf) {
		return str_replace('-', '', str_replace('.','',$cpf));
	}

	function mask($mask, $content){
	
		for($i=0;$i<strlen($content);$i++){
			$mask[strpos($mask,"#")] = $content[$i];
		}
		return $mask;
	
	}
}

?>