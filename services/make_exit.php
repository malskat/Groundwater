<?php

	session_start();
	unset($_SESSION['user']);
	session_write_close();

	if(strpos($_GET['destination'], 'user') !== false ){

		header('Location: ../index.php');
	} else {
		header('Location: ' . $_GET['destination']);
	}

	die;

?>