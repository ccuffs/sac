<?php 
	require_once dirname(__FILE__).'/layout.php';

	layoutHeader('Oops!', View::baseUrl());
	
	echo '<div class="jumbotron">';
		echo '<div class="container">';
			echo '<h1>Oops!</h1>';
			echo '<p>Você acessou uma página inexistente ou que está temporariamente indisponível.</p>';
		echo '</div>';
	echo '</div>';

	echo '<div class="container">';
		echo '<div class="row">';
			echo '<div class="col-md-12">';
				echo '<p></p>';
			echo '</div>';
		echo '</div>';
	echo '</div>';
	
	layoutFooter(View::baseUrl());
?>