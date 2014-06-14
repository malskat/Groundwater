<?php

require_once '../config/constants.php';
require_once '../data/struture_data.php';


if (isset($_POST["individualCode"]) && $_POST["individualCode"] != "" && isset($_POST["samplingDate"]) && $_POST["samplingDate"] != "" ) {

	$strutureData = new Struture();	

	if(!isset($_POST["struture_id"])) {
		$success = $strutureData->insert($_POST);
	} else {
		$success = $strutureData->update($_POST);
	}
	
	if($success == 1) {
		header('Location: /forms/struture.html?success=1&individualCode=' . $_POST["individualCode"]);
	} else {
		header('Location: /forms/struture.html?success=-3&reason=Não houve alteração nenhuma!&individualCode=' . $_POST["individualCode"]);
	}

	
} else {
	header('Location: /forms/struture.html?success=-1&reason=Faltam parametros à estrutura!&individualCode=' . $_POST["individualCode"]);
}