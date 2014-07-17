<?php

require_once 'gObject.php';

class EcoFisio extends gObject {

	private $_blocks = array(array("code" => "leaf", "designation" => "Leaf", "show" => true, "attributes" => array("leaf_13C", "leaf_15N", "leaf_perN", "leaf_perC", "leaf_CN")),
		            array("code" => "xylem", "designation" => "Xylem Water", "show" => true, "attributes" => array("xylemWater_18O")),
		            array("code" => "photo", "designation" => "Photo Synthetic", "show" => false, "attributes" => array("wi", "pri", "chl", "chl_ndi", "ndvi")));

	function __construct (){
		$this->_entityName = 'eco_fisio';
		$this->_fieldList = array("Campanha", "Data de Amostragem", "Leaf_13C", "Leaf_15N", "XylenWater_18O", "WI", "PRI");
		$this->_totalRows = 5;
		$this->_orderBy = $this->_entityName . '_id';
	}

	function getEcoFisioDataBlocks () {

		return $this->_blocks;
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

	function getEcoFisioSpeciesChart($whereClause){

		require_once '../core/core_database.php';

		$query = 'Select sp.species_id, sp.species, sp.genus, i.individualCode, ef.leaf_13C, ef.leaf_15N, 
						ef.leaf_perN, ef.leaf_perC, ef.leaf_CN, ef.xylemWater_18O, 
						ef.pri, ef.wi, ef.chl, ef.chl_ndi, ef.ndvi
					From species sp
					Left Join individual i On i.species_id = sp.species_id
					Left Join eco_fisio ef On ef.individualCode = i.individualCode
					Left Join plot p ON i.plot_id = p.plot_id
					Left Join site s ON s.site_id = p.site_id
					Where ' . $whereClause . '
					Order by xylemWater_18O DESC';

		return CoreDatabase::selectDBQuery($query, 0, -1);

	}

	function insert ($toInsert = array()){

		require_once '../core/core_database.php';

		$fields = '';
		$values = '';

		foreach ($toInsert as $key => $value) {
			if($value != ""){
				$fields .= '`'. $key . '`, ';

				if ($key == 'individualCode' || $key == 'sampling_campaign_id' || $key == 'samplingDate' || $key == 'file') {
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

	function update ($toUpdate){

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
				$arrayToFill['wi'] = ($line[$starter] != "" ? $line[$starter] : 'NULL');
	        	$arrayToFill['pri'] = ($line[$starter + 1] != "" ? $line[$starter + 1] : 'NULL');
	        	$arrayToFill['chl'] = ($line[$starter + 2] != "" ? $line[$starter + 2] : 'NULL');
	        	$arrayToFill['chl_ndi'] = ($line[$starter + 3] != "" ? $line[$starter + 3] : 'NULL');
	        	$arrayToFill['ndvi'] = ($line[$starter + 4] != "" ? $line[$starter + 4] : 'NULL');
				break;
			}

		}

	}

}