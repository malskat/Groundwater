<?php 	
	require_once 'config/constants.php';
	require_once 'data/user_data.php';

	$userData = new User();
	$_BIOLOGYST_LOGGED = $userData->validateActiveUser();
	

	ini_set('display_errors',1);
	ini_set('display_startup_erros',1);
	error_reporting(E_ALL);

?>