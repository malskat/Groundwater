<?php

require_once '../config/constants.php';
require_once '../data/user_data.php';
require_once "../checkBiologyst.php";

if (!$_BIOLOGYST_LOGGED) {
	header('Location: /forms/login.php?success=-1&reason=Não existe nenhum utilizador com login activo.');
	die;
} 



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

	$urlComplement = '';

	if(!isset($_POST["user_id"])) {

		$_POST["email"] = $_POST["emailUser"];
		unset($_POST["emailUser"]);

		//validar se existe algum utilizador com o mesmo email
		$user = $userData->getUserBy("email = '" . $_POST["email"] . "'", -1);
		var_dump($user);
		if (count($user) > 0) {
			$reply['_success_'] = -4;
		} else {
			$reply = $userData->insert($_POST);
			$urlComplement = '&user_id=' . $reply['_id_'];
		}

	} else {


		$_POST["biologyst_id"] = $_POST["user_id"];
		unset($_POST["user_id"]);
		unset($_POST["emailUser"]);

		$reply = $userData->update($_POST);
		$urlComplement = '&user_id=' . $_POST["biologyst_id"];

		/*$user = $userData->getUserBy("email = '" . $_POST["email"] . "' and biologyst_id <> " . $_POST["biologyst_id"], -1);
		if (count($user) > 0) {
			$success = -4;
		} else {
			$success = $userData->updateUser($_POST);
		}*/
	}
	
	if($reply['_success_'] == 1) {
		header('Location: /forms/user.php?success=1' . $urlComplement);
	} else if ($reply['_success_'] == -4) {
		header('Location: /forms/user.php?success=-1&reason=Já existe um utilizador com este email!');
	} else {
		header('Location: /forms/user.php?success=-3&reason=Não houve alteração nenhuma!' . $urlComplement);
	}

	
} else {
	header('Location: forms/user.php?success=-1&reason=Faltam parametros ao utilizador!');
}