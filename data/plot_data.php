<?php

require_once '/gObject.php';

class Plot extends gObject {

	function __construct (){
		$this->_entityName = 'plot';
		$this->_fieldList = array("#", "Código", "Site", "Tipo", "CoordenadaX", "CoordenadaY", "#Indivíduos");
		$this->_totalRows = 10;
	}


	function getPlotsSite($page = 0, $withTotalIndividuals = 0){

		include_once '../core/core_database.php';
		return CoreDatabase::selectDBQuery('Select SQL_CALC_FOUND_ROWS p.*, s.code as siteCode, s.title ' .
							($withTotalIndividuals == 1 ? ', count(i.individualCode) as totalIndividuals' : '') . ' 
							From Plot p 
							Join Site s On s.site_id = p.site_id ' . 
							($withTotalIndividuals == 1 ? ' Left Join Individual i On i.plot_id = p.plot_id Group by p.plot_id ' : '') . '
							Order By s.title', $this->_totalRows, $page);
	}

	function getPlotBy($whereClause, $page = 0, $withTotalIndividuals = 0){

		include_once '../core/core_database.php';
		$query = 'Select SQL_CALC_FOUND_ROWS p.*, s.code as siteCode, s.title' .
					($withTotalIndividuals == 1 ? ', count(i.individualCode) as totalIndividuals' : '') . '
				From plot p
				Join Site s On s.site_id = p.site_id ' . 
					($withTotalIndividuals == 1 ? ' Left Join Individual i On i.plot_id = p.plot_id ' : '') . '
				Where ' . $whereClause . ($withTotalIndividuals == 1 ? ' Group by p.plot_id ' : '') . 
				' Order By s.title';
				
		return CoreDatabase::selectDBQuery($query, $this->_totalRows, $page);

	}

	function insertPlot($toInsert = array()){

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

	function updatePlot($toUpdate){

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
