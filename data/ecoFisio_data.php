<?php

class EcoFisio {

	const TOTAL_ROWS_ECO_FISIO = 5;
	const DB_ENTITY_NAME = 'eco_fisio';

	function getEcoFisioFieldsListConf (){

		return array("Campanha", "Data de Amostragem", "Leaf_13C", "Leaf_15N", "XylenWater_18O", "PhotoSynthetic_PI");
	}

	function getEcoFisioDataBlocks () {

		return array(array("code" => "leaf", "designation" => "Leaf", "attributes" => array("leaf_13C", "leaf_15N", "leaf_perN", "leaf_perC", "leaf_CN")), 
		            array("code" => "xylem", "designation" => "Xylem Water", "attributes" => array("xylemWater_18O")), 
		            array("code" => "photo", "designation" => "Photo Synthetic", "attributes" => array("photosinthetic_PI", "photosinthetic_NWI", "photosinthetic_BP")));
	}

	function getEcoFisioBy ($whereClause, $orderBy = '', $page = 0){

		require_once '../core/core_database.php';
		$query = 'Select SQL_CALC_FOUND_ROWS ef.*, sc.designation as campaignDesignation
					From eco_fisio ef
					Join sampling_campaign sc On sc.sampling_campaign_id = ef.sampling_campaign_id
					Where ' . $whereClause . 
					($orderBy != '' ? ' Order By ' . $orderBy : '');
		return selectDBQuery($query, EcoFisio::TOTAL_ROWS_ECO_FISIO, $page);

	}

	function insertEcoFisio ($toInsert = array()){

		require_once '../core/core_database.php';

		$fields = '';
		$values = '';

		foreach ($toInsert as $key => $value) {
			if($value != ""){
				$fields .= '`'. $key . '`, ';

				if ($key == 'individualCode' || $key == 'sampling_campaign_id' || $key == 'samplingDate') {
					$values .= "'" . $value . "', ";
				} else {
					$values .= '' . str_replace(",", ".", $value) . ', ';
				}
			}
		}

		$fields = substr($fields, 0, -2);
		$values = substr($values, 0, -2);

		return insertDB(EcoFisio::DB_ENTITY_NAME, $fields, $values);
	}

	function updateEcoFisio ($toUpdate){

		require_once '../core/core_database.php';

		$set = '';
		foreach ($toUpdate as $key => $value) {
			if($key != 'individualCode' && $key != 'sampling_campaign_id'){
				if ($key != 'samplingDate') {
					$set .= '`'. $key . '` = ' . str_replace(",", ".", $value) . ', ';
				} else {
					$set .= '`'. $key . '` = ' . "'" . $value . "', "; 
				}
			}
		}

		$set = substr($set, 0, -2);
		$where = " individualCode = '" . $toUpdate["individualCode"] . "' and sampling_campaign_id	 = " . $toUpdate["sampling_campaign_id"];

		return updateDB(EcoFisio::DB_ENTITY_NAME, $set, $where);
	}

	function delete_ecoFisio ($parameters = '' ){

		list($dummyKey, $privateKeys) = explode("=", $parameters);
		list($individualCode, $sampling_campaign_id) = explode("|", $privateKeys);
		$where = " individualCode = " . $individualCode . "' and sampling_campaign_id = '" . $sampling_campaign_id;

		require_once '../core/core_database.php';
		$where = str_replace("ecofisio", "eco_fisio", $where);
		return deleteDB(EcoFisio::DB_ENTITY_NAME, $where);
	}

}