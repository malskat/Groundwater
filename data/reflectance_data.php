<?php

require_once 'gObject.php';

class Reflectance extends gObject {

	private $_referenceWaveLength = array("529.6", "569.8", "680.0", "700.0", "706.6", "749.8", "898.8", "971.3");

	function __construct (){
		$this->_entityName = 'individual_reflectance';
		$this->_fieldList = array("Campaign", "File", "529.6", "569.8", "680.0", "700.0", "Creation Date");
		$this->_totalRows = 10;
		$this->_orderBy = $this->_entityName . '_id';
	}

	function getReferenceWaveLength () {

		return $this->_referenceWaveLength;
	}

	function getReflectanceBy ($whereClause, $orderBy = '', $page = 0){

		require_once '../core/core_database.php';

		$query = 'Select SQL_CALC_FOUND_ROWS ir.*, sc.designation as campaignDesignation
					From individual_reflectance ir
					Join sampling_campaign sc On sc.sampling_campaign_id = ir.sampling_campaign_id
					Where ' . $whereClause . 
					($orderBy != '' ? ' Order By ' . $orderBy : '');

		return CoreDatabase::selectDBQuery($query, $this->_totalRows, $page);

	}

	function insert ($toInsert = array()){

		require_once '../core/core_database.php';

		$fields = '';
		$values = '';

		foreach ($toInsert as $key => $value) {
			if($value != ""){
				$fields .= '`'. $key . '`, ';

				if ($key == 'individualCode' || $key == 'sampling_campaign_id' || $key == 'file') {
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
				if($key != 'individualCode' && $key != 'sampling_campaign_id' && $key != 'samplingDate') {
					$set .= '`'. $key . '` = ' . str_replace(",", ".", $value) . ', ';
				} else {
					$set .= '`'. $key . '` = ' . "'" . $value . "', "; 
				}
			}
		}

		$set = substr($set, 0, -2);
		$where = " individual_reflectance_id = '" . $toUpdate["individual_reflectance_id"] . "'";

		return CoreDatabase::updateDB($this->_entityName, $set, $where);
	}

	function delete ($parameters){

		require_once '../core/core_database.php';
		$whereClause = 'individual_' . $parameters;	//o where esta martelado porque o nome da tabela no mysql nao permite o mecanismo directo

		$reflectance = $this->getReflectanceBy ($whereClause, $orderBy = '', $page = -1);
		if (isset($reflectance[0]->individualCode)) {

			$deleteReply = CoreDatabase::deleteDB($this->_entityName, $whereClause);
			
			if (1 == $deleteReply) {
				$updateReply = $this->updateEcoFisioRefletanceValues ($reflectance[0]->individualCode, $reflectance[0]->sampling_campaign_id);
				$updateReply = $updateReply == 0 ? -3 : $updateReply;
				return $updateReply;
			} else {
				return $deleteReply;
			}

		} else {
			die('não encontrou o registo');
			return -1;
		}

		
	}

	function updateEcoFisioRefletanceValues ($individualCode, $sampling_campaign_id) {

		require_once '../core/core_database.php';

		return CoreDatabase::callBD("update_eco_fisio_indexes('" . $individualCode . "', '" . $sampling_campaign_id . "');");

	}

}