<?php

require_once '../config/constants.php';

var_dump($_GET);

switch($_GET["action"]){
	case "delete" : {
		require_once "../data/" . $_GET["class"] ."_data.php";
		$seasons = getSeasons(); 
		var_dump($seasons);
		break;
	}
}
die;

if(isset($_GET["class"])){
	header('Location: ' . PROJECT_URL . 'lists/' . $_GET["class"] . '_list.html?sucess=1');
} else {
	header('Location: ' . PROJECT_URL . 'index.html?');
}

