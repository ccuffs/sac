<?php 
	require_once dirname(__FILE__).'/layout.php';

	layoutHeader('Restrito', View::baseUrl());
	
	echo '<div class="hero-unit">';
		echo '<h1>Restrito!</h1>';
		echo '<p>Você não tem permissão para acessar a página solicitada.</p>';
	echo '</div>';

	echo '<div class="row">';
		echo '<div class="span12">';
		echo '</div>';
	echo '</div>';
	
	layoutFooter(View::baseUrl());
?>