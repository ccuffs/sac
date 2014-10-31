<?php 
	require_once dirname(__FILE__).'/inc/globals.php';
	
	authLogout();
	
	header('Location: index.php');
	exit();
?>