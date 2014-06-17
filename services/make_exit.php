<?php

	session_start();
	unset($_SESSION['user']);

	if(strpos($_GET['destination'], 'user') !== false ){

		header('Location: ../index.php');
	} else {
		header('Location: ' . $_GET['destination']);
	}

	die;

?>