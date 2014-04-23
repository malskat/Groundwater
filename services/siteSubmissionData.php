<?php

require_once '../config/constants.php';
require_once '../data/site_data.php';


if(isset($_POST["code"]) && $_POST["code"] != "" && isset($_POST["country"]) && $_POST["country"] != "" 
	&& isset($_POST["title"]) && $_POST["title"] != ""){

	if(!isset($_POST["site_id"])){
		$sucess = insertSite($_POST);
	}else{
		$sucess = updateSite($_POST);
	}
	
	if($sucess == 1){
		header('Location: ' . PROJECT_URL . 'lists/site-list.html?sucess=1');
	} else {
		header('Location: ' . PROJECT_URL . 'lists/site-list.html?sucess=-3&reason=Não houve alteração nenhuma!');
	}

	
}else{
	header('Location: ' . PROJECT_URL . 'forms/site.html?sucess=-1&reason=Faltam parametros!');
}
