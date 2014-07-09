<?php

require_once '../config/constants.php';

$action = (isset($_GET["action"]) ? $_GET["action"] : $_POST["action"]);

switch($action){
	case "delete" : {
		
		require_once PROJECT_PATH . "data/user_data.php";

		$newLocation = '';
		$parameters = '';
		$userData = new User();

		$parametersStartIndex = strpos($_SERVER['HTTP_REFERER'], '?');
		if ($parametersStartIndex !== false) {
			$parameters = substr($_SERVER['HTTP_REFERER'], $parametersStartIndex + 1);
			$parameters = str_replace("success=1", "", $parameters);
			$parameters = str_replace("success=2", "", $parameters);
			$parameters = str_replace("success=-1", "", $parameters);

			if (substr($parameters, -1) === '&') {
				$parameters = substr($parameters, 0,-1);
			}

			if (substr($parameters, 0, 1) === '&') {
				$parameters = substr($parameters, 1);
			}
		}
		
		if ($userData->validateActiveUser()) {

			require_once PROJECT_PATH . "data/" . $_GET["class"] ."_data.php";

			//chamada dinamica da funcao
			$instance = new $_GET["class"];
			$toReturn = $instance->delete($_GET["class"] . "_id = '" . $_GET["id"] . "'");

			if(isset($_GET["class"])){

				if (isset($_GET["redirect"])) {
					$newLocation = $_GET["redirect"] . '?' . ($parameters != '' && $parameters != '&' ? $parameters . '&' : '') . 'success=' . ($toReturn == 1 ? '2' : $toReturn . '&reason=Error deleting record. Please try again.');
				} else {
					$newLocation = '/lists/' . $_GET["class"] . '-list.php?' . ($parameters != '' && $parameters != '&' ? $parameters . '&' : '') . 'success=' . ($toReturn == 1 ? '2' : $toReturn . '&reason=Error deleting record. Please try again.');
				}
			} else {
				$newLocation = 'index.php';
			}

		} else {
			if (isset($_GET["redirect"])) {
				$newLocation = $_GET["redirect"] . '?' . ($parameters != '' && $parameters != '&' ? $parameters . '&' : '') . 'success=-1&reason=There is no logged user. Please login.';
			} else {
				$newLocation = '/lists/' . $_GET["class"] . '-list.php?' . ($parameters != '' && $parameters != '&' ? $parameters . '&' : '') . 'success=-1&reason=There is no logged user. Please login.';
			}
		}



		header('Location: ' . $newLocation);
		
		break;
	}

	case "search" : {
		if (count($_POST) > 1) {
			$filterOptions = "?";
			foreach($_POST as $key => $value){
				if ($key != 'action' && $key != 'class' && $value != 'none' && $value != "") {
					$filterOptions .= $key . '='. $value . '&';
				}
			}
			$filterOptions = substr($filterOptions, 0, -1);
			header('Location: /lists/' . $_POST["class"] . '-list.php' . $filterOptions);
		} else {
			header('Location: /lists/' . $_POST["class"] . '-list.php');
		} 
		break;
	}

	default : {
		header('Location: ' . PROJECT_URL );
		break;
	}
}



