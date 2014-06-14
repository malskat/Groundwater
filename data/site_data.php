<?php

require_once '/gObject.php';

class Site extends gObject {

	function __construct (){
		$this->_entityName = 'site';
		$this->_fieldList = array("#", "Código", "Designação", "País", "CoordenadaX", "CoordenadaY", "#Plots");
		$this->_totalRows = 10;
	}

	function getSites($page = 0, $withTotalPlots = 0){
		
		include_once '../core/core_database.php';
		$query = 'Select SQL_CALC_FOUND_ROWS s.* ' .
				($withTotalPlots == 1 ? ', count(p.plot_id) as totalPlots' : '') . 
				' From site s' . 
				($withTotalPlots == 1 ? ' Left Join plot p On p.site_id = s.site_id Group by s.site_id ' : '');
		return CoreDatabase::selectDBQuery($query, $this->_totalRows, $page);
	}

	function getSiteBy($whereClause, $page = 0){

		include_once '../core/core_database.php';
		$query = 'Select SQL_CALC_FOUND_ROWS s.* From site s Where ' . $whereClause;
		return CoreDatabase::selectDBQuery($query, $this->_totalRows, $page);

	}

	function insert ($toInsert = array()){

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

	function update ($toUpdate){

		require_once '../core/core_database.php';

		$set = '';
		foreach ($toUpdate as $key => $value) {
			if($key != 'site_id'){
				if($key == 'coordinateX' || $key == 'coordinateY'){
					$set .= '`'. $key . '` = ' . "'" . str_replace(",", ".", $value) . "', ";
				}else{
					$set .= '`'. $key . '` = ' . "'" . $value . "', "; 
				}
			}
		}

		$set = substr($set, 0, -2);
		$where = '`site_id` = ' . $toUpdate["site_id"];

		return CoreDatabase::updateDB($this->_entityName, $set, $where);

	}
}
