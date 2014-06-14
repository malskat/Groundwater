<?php

require_once '/gObject.php';

class EcoFisio extends gObject {

	function __construct (){
		$this->_entityName = 'eco_fisio';
		$this->_fieldList = array("Campanha", "Data de Amostragem", "Leaf_13C", "Leaf_15N", "XylenWater_18O", "PhotoSynthetic_PI");
		$this->_totalRows = 5;
		$this->_orderBy = $this->_entityName . '_id';
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

		return CoreDatabase::selectDBQuery($query, $this->_totalRows, $page);

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

		return CoreDatabase::insertDB($this->_entityName, $fields, $values);
	}

	function updateEcoFisio ($toUpdate){

		require_once '../core/core_database.php';

		$set = '';
		foreach ($toUpdate as $key => $value) {
			if($value != "") {
				if($key != 'individualCode' && $key != 'sampling_campaign_id'){
					if ($key != 'samplingDate') {
						$set .= '`'. $key . '` = ' . str_replace(",", ".", $value) . ', ';
					} else {
						$set .= '`'. $key . '` = ' . "'" . $value . "', "; 
					}
				}
			}
		}

		$set = substr($set, 0, -2);
		$where = " individualCode = '" . $toUpdate["individualCode"] . "' and sampling_campaign_id	 = " . $toUpdate["sampling_campaign_id"];

		return CoreDatabase::updateDB($this->_entityName, $set, $where);
	}

	function delete ($parameters = '' ){

		list($dummyKey, $privateKeys) = explode("=", $parameters);
		list($individualCode, $sampling_campaign_id) = explode("|", $privateKeys);
		$where = " individualCode = " . $individualCode . "' and sampling_campaign_id = '" . $sampling_campaign_id;

		require_once '../core/core_database.php';
		
		$where = str_replace("ecofisio", "eco_fisio", $where);
		return CoreDatabase::deleteDB($this->_entityName, $where);
	}

	function fillEcoAttributes (&$arrayToFill, $line, $block, $hasSamplingDate) {

		$starter = 0;
		if ($hasSamplingDate){
			$starter = 2;
		} else {
			$starter = 1;
		}

		switch ($block) {
			case "leaf" : {
				$arrayToFill['leaf_13C'] = ($line[$starter] != "" ? $line[$starter] : 'NULL');
	        	$arrayToFill['leaf_15N'] = ($line[$starter + 1] != "" ? $line[$starter + 1] : 'NULL');
	        	$arrayToFill['leaf_perN'] = ($line[$starter + 2] != "" ? $line[$starter + 2] : 'NULL');
	        	$arrayToFill['leaf_perC'] = ($line[$starter + 3] != "" ? $line[$starter + 3] : 'NULL');
	        	$arrayToFill['leaf_CN'] = ($line[$starter + 4] != "" ? $line[$starter + 4] : 'NULL');
				break;
			}
			case "xylem" : {
				$arrayToFill['xylemWater_18O'] = ($line[$starter] != "" ? $line[$starter] : 'NULL');
				break;
			}
			case "photo" : {
				$arrayToFill['photosynthetic_PI'] = ($line[$starter] != "" ? $line[$starter] : 'NULL');
	        	$arrayToFill['photosynthetic_NWI'] = ($line[$starter + 1] != "" ? $line[$starter + 1] : 'NULL');
	        	$arrayToFill['photosynthetic_BP'] = ($line[$starter + 2] != "" ? $line[$starter + 2] : 'NULL');
				break;
			}

		}

	}

}