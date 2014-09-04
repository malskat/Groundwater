<?php

require_once 'gObject.php';

class PlotAttribute extends gObject {

	function __construct () {
		$this->_entityName = 'plot_attribute';
		$this->_fieldList = array("#", "Measure Date", "Campaign", "Ground Water 18O", "Pond Water 18O", "GW Level", "Creation Date");
		$this->_totalRows = 5;
	}

	function getPlotAttributeBy($whereClause, $page = 0) {
		
		include_once '../core/core_database.php';
		$query = 'Select SQL_CALC_FOUND_ROWS pa.*, c.designation as campaignDesignation, p.code as plotCode, s.title as siteTitle ' . 
				' From plot_attribute pa 
				Join sampling_campaign c On c.sampling_campaign_id = pa.sampling_campaign_id
				Join plot p On p.plot_id = pa.plot_id
				Join site s On s.site_id = p.site_id
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

				if ($key == 'sampling_campaign_id' || $key == 'measureDate' || $key == 'file') {
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
			if($key != 'plot_attribute_id' && $value != "") {
				if ($key != 'measureDate' && $key != 'sampling_campaign_id') {
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
		$where = str_replace("plotattribute_id", "plot_attribute_id", $where);
		
		return CoreDatabase::deleteDB($this->_entityName, $where);
	}
}