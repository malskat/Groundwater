<?php

require_once '../config/constants.php';
require_once '../data/site_data.php';


if(isset($_POST["code"]) && $_POST["code"] != "" && isset($_POST["country"]) && $_POST["country"] != "" 
	&& isset($_POST["title"]) && $_POST["title"] != "") {

	$siteData = new Site();	

	if(!isset($_POST["site_id"])) {
		$success = $siteData->insertSite($_POST);
	} else {
		$success = $siteData->updateSite($_POST);
	}
	
	if($success == 1) {
		header('Location: ' . PROJECT_URL . 'lists/site-list.html?success=1');
	} else {
		header('Location: ' . PROJECT_URL . 'lists/site-list.html?success=-3&reason=Não houve alteração nenhuma!');
	}

	
}else{
	header('Location: ' . PROJECT_URL . 'forms/site.html?success=-1&reason=Faltam parametros ao local!');
}
