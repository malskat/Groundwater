<?php

require_once '../config/constants.php';
require_once '../data/season_data.php';

if(isset($_POST["startDate"]) && $_POST["startDate"] != "" 
	&& isset($_POST["endDate"]) && $_POST["endDate"] != "" && 
		isset($_POST["code"]) && $_POST["code"] != ""){

	$seasonData = new Season();

	$urlComplement = '';

	if(!isset($_POST["season_id"])){
		$reply = $seasonData->insert($_POST);
		$urlComplement = '&season_id=' . $reply['_id_'];
	}else{
		$reply = $seasonData->update($_POST);
		$urlComplement = '&season_id=' . $_POST["season_id"];
	}
	
	if($reply['_success_'] == 1){
		header('Location: /forms/season.php?success=1' . $urlComplement);
	} else {
		header('Location: /forms/season.php?success=-3&reason=Não houve alteração nenhuma!' . $urlComplement);
	}

	
}else{
	header('Location: /forms/season.php?success=-1&reason=Faltam parametros!');
}

