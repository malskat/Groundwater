<?php

require_once '../config/constants.php';
require_once '../data/site_data.php';


if (isset($_POST["code"]) && $_POST["code"] != "" && isset($_POST["country"]) && $_POST["country"] != "" 
	&& isset($_POST["title"]) && $_POST["title"] != "") {

	$siteData = new Site();	
	$urlComplement = '';

	if(!isset($_POST["site_id"])) {
		$reply = $siteData->insert($_POST);
		$urlComplement = '&site_id=' . $reply['_id_'];
	} else {
		$reply = $siteData->update($_POST);
			$urlComplement = '&site_id=' . $_POST["site_id"];
	}
	
	if($reply['_success_'] == 1) {
		header('Location: /forms/site.php?success=1' . $urlComplement);
	} else {
		header('Location: /forms/site.php?success=-3&reason=Não houve alteração nenhuma!' . $urlComplement);
	}

	
} else {
	header('Location: /forms/site.php?success=-1&reason=Faltam parametros ao local!');
}
