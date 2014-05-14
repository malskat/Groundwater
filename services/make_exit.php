<?php

	session_start();
	unset($_SESSION['user']);

	if(strpos($_GET['destination'], 'user') !== false ){
		require_once '../config/constants.php';
		header('Location: ' . PROJECT_URL);

	} else {
		header('Location: ' . $_GET['destination']);
	}

	die;

?>