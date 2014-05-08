<?php

require_once '../config/constants.php';
require_once '../data/campaign_data.php';

var_dump($_POST);

if(isset($_POST["startDate"]) && $_POST["startDate"] != "" && isset($_POST["endDate"]) && $_POST["endDate"] != "" 
	&& isset($_POST["designation"]) && $_POST["designation"] != "" 
	&& isset($_POST["season_id"]) && $_POST["season_id"] != ""
	&& isset($_POST["site_id"]) && $_POST["site_id"] != ""){

	if(!isset($_POST["sampling_campaign_id"])){
		$success = insertCampaign($_POST);
	}else{
		$success = updateCampaign($_POST);
	}
	
	if($success == 1){
		header('Location: ' . PROJECT_URL . 'lists/campaign-list.html?success=1');
	} else {
		header('Location: ' . PROJECT_URL . 'lists/campaign-list.html?success=-3&reason=Não houve alteração nenhuma!');
	}

	
}else{
	header('Location: ' . PROJECT_URL . 'forms/campaign.html?success=-1&reason=Faltam parametros!');
}
