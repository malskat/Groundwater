<?php

require_once '../config/constants.php';
require_once '../data/user_data.php';
require_once "../checkBiologyst.php";

if (!$_BIOLOGYST_LOGGED) {
	header('Location: /forms/login.php?response=-1');
	die;
} 


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

	//tratar das permissoes
	$submittedPermission = false;
	$biologyst_id = false;

	if (isset($_POST["permission"]) && $_POST["permission"] != "") {
		$submittedPermission = $_POST["permission"];	
		unset($_POST["permission"]);
	}

	if(!isset($_POST["user_id"])) {

		$_POST["email"] = $_POST["emailUser"];
		unset($_POST["emailUser"]);

		//validar se existe algum utilizador com o mesmo email
		$user = $userData->getUserBy("email = '" . $_POST["email"] . "'", -1);

		if (count($user) > 0) {
			$reply['_success_'] = -4;
		} else {
			$reply = $userData->insert($_POST);
			$urlComplement = '&user_id=' . $reply['_id_'];
			$biologyst_id = $reply['_id_'];
		}

	} else {


		$_POST["biologyst_id"] = $_POST["user_id"];
		unset($_POST["user_id"]);
		unset($_POST["emailUser"]);

		$reply = $userData->update($_POST);

		//actualizar, caso seja necessario, o nome e sobrenome do utilizador logado
		if ($_SESSION['user']['user_id'] == $_POST["biologyst_id"]) {
			session_start();
			$_SESSION['user']['first_name'] = $_POST["first_name"];
			$_SESSION['user']['last_name'] = $_POST["last_name"];
			session_write_close(); 
		}
		
		$urlComplement = '&user_id=' . $_POST["biologyst_id"];
		$biologyst_id = $_POST["biologyst_id"];

	}
	
	if($reply['_success_'] == 1) {

		//actualizar permissoes
		if ($submittedPermission !== false ) {
			require_once PROJECT_PATH . 'core/core_system.php';
			require_once PROJECT_PATH . 'data/userpermission_data.php';
			
			$userpermissionData = new UserPermission();
			$userpermissionData->delete("biologyst_id = " . $biologyst_id);

			$systemClasses = CoreSystem::getClasses();
			
			foreach ($systemClasses as $class) {
				if ($submittedPermission == 'master' || ($submittedPermission == 'regular' && $class != 'user') ) {
					$toInsert = array("biologyst_id" => $biologyst_id, "module" => $class);
					$userpermissionData->insert($toInsert);
				}
			}
		}

		header('Location: /forms/user.php?response=701' . $urlComplement);
	} else if ($reply['_success_'] == -4) {
		header('Location: /forms/user.php?response=704');
	} else {
		header('Location: /forms/user.php?response=703' . $urlComplement);
	}

	
} else {
	header('Location: forms/user.php?response=702');
}