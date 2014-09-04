<?php

require_once 'gObject.php';

class PlotSoil extends gObject {

	function __construct () {
		$this->_entityName = 'plot_soil';
		$this->_fieldList = array("Measure Date", "Campaign", "Soil Code", "18O 10cm", "18O 30cm", "18O 50cm", "Water Content", "Creation Date");
		$this->_totalRows = 10;
	}


	function getPlotSoilBy($whereClause, $page = 0) {
		
		include_once '../core/core_database.php';
		$query = 'Select SQL_CALC_FOUND_ROWS ps.*, c.designation as campaignDesignation, p.code as plotCode, s.title as siteTitle ' .
				' From plot_soil ps
				Join plot p On p.plot_id = ps.plot_id
				Join site s On s.site_id = p.site_id
				Join sampling_campaign c On c.sampling_campaign_id = ps.sampling_campaign_id
				Where ' . $whereClause;
		return CoreDatabase::selectDBQuery($query, $this->_totalRows, $page);
	}

	function insert ($toInsert = array()) {

		require_once '../core/core_database.php';

		$fields = '';
		$values = '';

		foreach ($toInsert as $key => $value) {
			if($value != ""){
				$fields .= '`'. $key . '`, ';

				if ($key == 'soilCode' || $key == 'file' || $key == 'measureDate') {
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
			if($key != 'plot_soil_id' && $value != "") {
				if ($key != 'soilCode' && $key != 'measureDate') {
					$set .= '`'. $key . '` = ' . str_replace(",", ".", $value) . ', ';
				} else {
					$set .= '`'. $key . '` = ' . "'" . $value . "', "; 
				}
			}
		}

		$set = substr($set, 0, -2);
		$where = $this->_entityName . "_id = " . $toUpdate[$this->_entityName . '_id'];

		return CoreDatabase::updateDB($this->_entityName, $set, $where);
	}

	function delete($where){

		require_once '../core/core_database.php';
		$where = str_replace("plotsoil_id", "plot_soil_id", $where);
		
		return CoreDatabase::deleteDB($this->_entityName, $where);
	}

}