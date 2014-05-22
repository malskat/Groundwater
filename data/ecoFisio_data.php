<?php

class EcoFisio {

	const TOTAL_ROWS_ECO_FISIO = 5;
	const DB_ENTITY_NAME = 'eco_fisio';

	function getEcoFisioFieldsListConf(){

		return array("Leaf_13c", "Twig_18c", "WaterPot.", "PhotoSyn.");
	}

	function getEcoFisioBy($whereClause, $orderBy, $page = 0){

		require_once '../core/core_database.php';
		$query = 'Select SQL_CALC_FOUND_ROWS ef.*, sc.designation as campaignDesignation
					From eco_fisio ef
					Join sampling_campaign sc On sc.sampling_campaign_id = ef.sampling_campaign_id
					Where ' . $whereClause . '
					Order By ' . $orderBy;
		return selectDBQuery($query, EcoFisio::TOTAL_ROWS_ECO_FISIO, $page);

	}

	function insertEcoFisio($toInsert = array()){

		require_once '../core/core_database.php';

		$fields = '';
		$values = '';

		foreach ($toInsert as $key => $value) {
			if($value != ""){
				$fields .= '`'. $key . '`, ';

				if ($key == 'leaf_13c' || $key == 'twig_18o' || $key == 'waterPotencial'  || $key == 'photosyntheticsIndices') {
					$values .= '' . str_replace(",", ".", $value) . ', ';
				} else {
					$values .= "'" . $value . "', ";
				}
			}
		}

		$fields = substr($fields, 0, -2);
		$values = substr($values, 0, -2);

		return insertDB(EcoFisio::DB_ENTITY_NAME, $fields, $values);
	}

	function delete_ecoFisio($where = '' ){

		require_once '../core/core_database.php';
		$where = str_replace("ecofisio", "eco_fisio", $where);
		return deleteDB(EcoFisio::DB_ENTITY_NAME, $where);
	}

}