<?php

class Plot {

	const TOTAL_ROWS_PLOT = 10;

	function getPlotFieldsListConf(){

		return array("#", "Código", "Site", "Tipo", "CoordenadaX", "CoordenadaY", "#Indivíduos");
	}

	function getPlots($page = 0){

		include_once '../core/core_database.php';
		return selectDB('plot', Plot::TOTAL_ROWS_PLOT, $page);
	}

	function getPlotsSite($page = 0, $withTotalIndividuals = 0){

		include_once '../core/core_database.php';
		return selectDBQuery('Select SQL_CALC_FOUND_ROWS p.*, s.code as siteCode, s.title ' .
							($withTotalIndividuals == 1 ? ', count(i.individualCode) as totalIndividuals' : '') . ' 
							From Plot p 
							Join Site s On s.site_id = p.site_id ' . 
							($withTotalIndividuals == 1 ? ' Left Join Individual i On i.plot_id = p.plot_id Group by p.plot_id ' : '') . '
							Order By s.title', Plot::TOTAL_ROWS_PLOT, $page);
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
				
		return selectDBQuery($query, Plot::TOTAL_ROWS_PLOT, $page);

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


		return insertDB('plot', $fields, $values);

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

		return updateDB('plot', $set, $where);

	}

	function delete_plot($where){

		require_once '../core/core_database.php';

		return deleteDB('plot', $where);
	}
}
