<?php

require_once 'gObject.php';

class Plot extends gObject {

	function __construct (){
		$this->_entityName = 'plot';
		$this->_fieldList = array("#", "Code", "Site", "Type", "CoordinateX", "CoordinateY", "#Individuals", "#Water Info", "#Soil Info");
		$this->_totalRows = 10;
	}


	function getPlotsSite($page = 0, $withTotals = 0) {

		include_once '../core/core_database.php';
		return CoreDatabase::selectDBQuery('Select SQL_CALC_FOUND_ROWS p.*, s.code as siteCode, s.title ' .
							($withTotals == 1 ? ', (select count(1) from individual i where i.plot_id =  p.plot_id)  as totalIndividuals ' : '') .
							($withTotals == 1 ? ', (select count(1) from plot_attribute pa where pa.plot_id =  p.plot_id)  as totalWaterSamples ' : '') .
							($withTotals == 1 ? ', (select count(1) from plot_soil ps where ps.plot_id =  p.plot_id)  as totalSoilSamples ' : '') .
							' From plot p 
							Join site s On s.site_id = p.site_id ' . 
							' Order By s.title', $this->_totalRows, $page);
	}

	function getPlotBy($whereClause, $page = 0, $withTotals = 0) {

		include_once '../core/core_database.php';
		$query = 'Select SQL_CALC_FOUND_ROWS p.*, s.code as siteCode, s.title' .
				($withTotals == 1 ? ', (select count(1) from individual i where i.plot_id =  p.plot_id)  as totalIndividuals ' : '') .
				($withTotals == 1 ? ', (select count(1) from plot_attribute pa where pa.plot_id =  p.plot_id)  as totalWaterSamples ' : '') .
				($withTotals == 1 ? ', (select count(1) from plot_soil ps where ps.plot_id =  p.plot_id)  as totalSoilSamples ' : '') .
				' From plot p
				Join site s On s.site_id = p.site_id
				Where ' . $whereClause .  
				' Order By s.title';
				
		return CoreDatabase::selectDBQuery($query, $this->_totalRows, $page);

	}

	function insert($toInsert = array()) {

		require_once '../core/core_database.php';

		$fields = '';
		$values = '';

		foreach ($toInsert as $key => $value) {
			if($value != ""){
				$fields .= '`'. $key . '`, ';
				if($key == 'coordinateX' || $key == 'coordinateY'){
					$values .= '' . str_replace(",", ".", $value) . ', ';
				}else{
					$values .= "'" . $value . "', ";
				}
			}
		}

		$fields = substr($fields, 0, -2);
		$values = substr($values, 0, -2);


		return CoreDatabase::insertDB($this->_entityName, $fields, $values);

	}

	function update($toUpdate) {

		require_once '../core/core_database.php';

		$set = '';
		foreach ($toUpdate as $key => $value) {
			if($key != 'plot_id'){
				if($key == 'coordinateX' || $key == 'coordinateY'){
					$set .= '`'. $key . '` = ' . "'" . str_replace(",", ".", $value) . "', ";
				}else{
					$set .= '`'. $key . '` = ' . "'" . $value . "', "; 
				}
			}
		}

		$set = substr($set, 0, -2);
		$where = '`plot_id` = ' . $toUpdate["plot_id"];

		return CoreDatabase::updateDB($this->_entityName, $set, $where);

	}
}
