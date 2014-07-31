<?php

require_once '../config/constants.php';
require_once '../data/campaign_data.php';
require_once "../checkBiologyst.php";

if (!$_BIOLOGYST_LOGGED) {
	header('Location: /forms/login.php?response=-1');
	die;
} 


if(isset($_POST["startDate"]) && $_POST["startDate"] != "" && isset($_POST["endDate"]) && $_POST["endDate"] != "" 
	&& isset($_POST["designation"]) && $_POST["designation"] != "" 
	&& isset($_POST["season_id"]) && $_POST["season_id"] != ""
	&& isset($_POST["site_id"]) && $_POST["site_id"] != ""){

	$campaignData = new Campaign();

	$urlComplement = '';

	if(!isset($_POST["sampling_campaign_id"])){
		$reply = $campaignData->insert($_POST);
		$urlComplement = '&campaign_id=' . $reply['_id_'];
	}else{
		$reply = $campaignData->update($_POST);
		$urlComplement = '&campaign_id=' . $_POST["sampling_campaign_id"];
	}
	
	if($reply['_success_'] == 1){
		header('Location: /forms/campaign.php?response=301' . $urlComplement);
	} else {
		header('Location: /forms/campaign.php?response=303' . $urlComplement);
	}

	
}else{
	header('Location: /forms/campaign.php?response=302');
}
