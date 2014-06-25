<?php 	
	session_start();
	require_once 'config/constants.php';

	$_BIOLOGYST_LOGGED = false;
	if(isset($_SESSION['user']) && ($_SESSION['user']['entrance'] + PROJECT_LOGGED_PERMITED_TIME) >= time()) {
		$_BIOLOGYST_LOGGED = true;
	} else if (isset($_SESSION['user'])) {
		//retirar o user de sessao caso tenha passado o tempo permitido de acesso autorizado
		unset($_SESSION['user']);
	}

	ini_set('display_errors',1);
	ini_set('display_startup_erros',1);
	error_reporting(E_ALL);

?>