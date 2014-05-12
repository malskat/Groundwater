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
		$_SESSION['user']['first_name'] = $user[0]->first_name;
		$_SESSION['user']['last_name'] = $user[0]->last_name; 

		header('Location: ' . $_POST['destination']);
	} else {
		header('Location: ' . $_POST['destination'] . '?success=-4&reason=login inválido');
	}

?>