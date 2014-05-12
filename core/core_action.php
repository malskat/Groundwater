<?php

require_once '../config/constants.php';

$action = (isset($_GET["action"]) ? $_GET["action"] : $_POST["action"]);

switch($action){
	case "delete" : {
		require_once "../data/" . $_GET["class"] ."_data.php";
		
		//chamada dinamica da funcao
		$instance = new $_GET["class"];
		$deleteFunction = "delete_" . $_GET["class"];
		$toReturn = $instance->$deleteFunction($_GET["class"] . "_id = '" . $_GET["id"] . "'");
		
		if(isset($_GET["class"])){
			header('Location: ' . PROJECT_URL . 'lists/' . $_GET["class"] . '-list.html?success=' . ($toReturn == 1 ? 2 : $toReturn));
		} else {
			header('Location: ' . PROJECT_URL . 'index.html?');
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
			header('Location: ' . PROJECT_URL . 'lists/' . $_POST["class"] . '-list.html' . $filterOptions);
		} else {
			header('Location: ' . PROJECT_URL . 'lists/' . $_POST["class"] . '-list.html');
		} 
		break;
	}

	default : {
		var_dump(PROJECT_URL);
		header('Location: ' . PROJECT_URL );
		break;
	}
}



