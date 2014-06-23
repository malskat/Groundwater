<?php

require_once '../config/constants.php';

$action = (isset($_GET["action"]) ? $_GET["action"] : $_POST["action"]);

switch($action){
	case "delete" : {
		require_once "../data/" . $_GET["class"] ."_data.php";
		
		//chamada dinamica da funcao
		$instance = new $_GET["class"];
		$toReturn = $instance->delete($_GET["class"] . "_id = '" . $_GET["id"] . "'");
		
		if(isset($_GET["class"])){

			$parameters = '';
			$parametersIndex = strpos($_SERVER['HTTP_REFERER'], '?');
			if ($parametersIndex !== false) {
				$parameters = substr($_SERVER['HTTP_REFERER'], $parametersIndex + 1) . '&';
				$parameters = str_replace("success=1", "", $parameters);
				$parameters = str_replace("success=2", "", $parameters);
			}
	
			if (isset($_GET["redirect"])) {
				header('Location: ' . $_GET["redirect"] . '?' . ($parameters != '&' ? $parameters : '') . 'success=' . ($toReturn == 1 ? 2 : $toReturn));
			} else {
				header('Location: /lists/' . $_GET["class"] . '-list.php?' . ($parameters != '&' ? $parameters : '') . 'success=' . ($toReturn == 1 ? 2 : $toReturn));
			}
		} else {
			header('Location: index.php');
		}
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



