<?php

	require_once '../config/constants.php';
	require_once '../data/user_data.php';

	$userData = new User();
	$user = $userData->validateLogin($_POST['email'], $_POST['password']);
	if ($user) {

		//actualizar o registo do utilizador
		$userData->updateLastLogin($user[0]->biologyst_id);

		//actualizar sessao
		session_start();
		$_SESSION['user']['user_id'] = $user[0]->biologyst_id;
		$_SESSION['user']['entrance'] = time(); 
		$_SESSION['user']['first_name'] = $user[0]->first_name;
		$_SESSION['user']['last_name'] = $user[0]->last_name;
		session_write_close(); 

		$next_address = $_POST['destination'];
		if (strpos($_POST['destination'], 'login') !== false) {
			$next_address = '/lists/individual-list.php';
		}

		header('Location: ' . $next_address);
	} else {
		header('Location: ' . PROJECT_URL . 'forms/login.php?success=-4');
	}

?>