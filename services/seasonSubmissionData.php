<?php

require_once '../config/constants.php';
require_once '../data/season_data.php';

if(isset($_POST["startDate"]) && $_POST["startDate"] != "" 
	&& isset($_POST["endDate"]) && $_POST["endDate"] != "" && 
		isset($_POST["code"]) && $_POST["code"] != ""){

	if(!isset($_POST["season_id"])){
		$sucess = insertSeason($_POST);
	}else{
		$sucess = updateSeason($_POST);
	}
	
	if($sucess == 1){
		header('Location: ' . PROJECT_URL . 'lists/season-list.html?sucess=1');
	} else {
		header('Location: ' . PROJECT_URL . 'lists/season-list.html?sucess=-3&reason=Não houve alteração nenhuma!');
	}

	
}else{
	header('Location: ' . PROJECT_URL . 'forms/season.html?sucess=-1&reason=Faltam parametros!');
}

