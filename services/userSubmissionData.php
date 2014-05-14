<?php

require_once '../config/constants.php';
require_once '../data/user_data.php';


$success = 0;

if(isset($_POST["first_name"]) && $_POST["first_name"] != "" && isset($_POST["last_name"]) && $_POST["last_name"] != "" 
	&& isset($_POST["emailUser"]) && $_POST["emailUser"] != "") {


	$userData = new User(); 

	if (isset($_POST["passwordUser"]) && $_POST["passwordUser"] != "") {

		//validar se a funcao de encriptacao e validacao de password existe
		$passHashCompatible = function_exists('password_hash');
		if (!$passHashCompatible) {
			require_once('../libs/password.php');
		}

		$passwordFromPost = trim($_POST["passwordUser"]);
		$hashedPassword = password_hash($passwordFromPost, PASSWORD_BCRYPT, $userData->hashOptions);

		$_POST["password"] = $hashedPassword;
		unset($_POST["passwordUser"]);
	}

	$_POST["email"] = $_POST["emailUser"];
	unset($_POST["emailUser"]);


	if(!isset($_POST["user_id"])) {

		//validar se existe algum utilizador com o mesmo email
		$user = $userData->getUserBy("email = '" . $_POST["email"] . "'", -1);
		if (count($user) > 0) {
			$success = -4;
		} else {
			$success = $userData->insertUser($_POST);
		}

	} else {


		$_POST["biologyst_id"] = $_POST["user_id"];
		unset($_POST["user_id"]);

		$user = $userData->getUserBy("email = '" . $_POST["email"] . "' and biologyst_id <> " . $_POST["biologyst_id"], -1);
		if (count($user) > 0) {
			$success = -4;
		} else {
			$success = $userData->updateUser($_POST);
		}
	}
	
	if($success == 1) {
		header('Location: ' . PROJECT_URL . 'lists/user-list.html?success=1');
	} else if ($success == -4) {
		header('Location: ' . PROJECT_URL . 'forms/user.html?' . (isset($_POST["biologyst_id"]) ? "user_id=" . $_POST["biologyst_id"] . "&" : "")  . 'success=-1&reason=Já existe um utilizador com este email!');
	} else {
		header('Location: ' . PROJECT_URL . 'lists/user-list.html?success=-3&reason=Não houve alteração nenhuma!');
	}

	
} else {
	header('Location: ' . PROJECT_URL . 'forms/user.html?success=-1&reason=Faltam parametros ao utilizador!');
}