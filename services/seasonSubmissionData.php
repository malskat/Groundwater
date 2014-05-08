<?php

require_once '../config/constants.php';
require_once '../data/season_data.php';

if(isset($_POST["startDate"]) && $_POST["startDate"] != "" 
	&& isset($_POST["endDate"]) && $_POST["endDate"] != "" && 
		isset($_POST["code"]) && $_POST["code"] != ""){

	if(!isset($_POST["season_id"])){
		$success = insertSeason($_POST);
	}else{
		$success = updateSeason($_POST);
	}
	
	if($success == 1){
		header('Location: ' . PROJECT_URL . 'lists/season-list.html?success=1');
	} else {
		header('Location: ' . PROJECT_URL . 'lists/season-list.html?success=-3&reason=Não houve alteração nenhuma!');
	}

	
}else{
	header('Location: ' . PROJECT_URL . 'forms/season.html?success=-1&reason=Faltam parametros!');
}

