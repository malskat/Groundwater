<?php

class Site {

	const TOTAL_ROWS_SITE = 10;
	const DB_ENTITY_NAME = 'site';

	function getSiteFieldsListConf(){

		return array("#", "Código", "Designação", "País", "CoordenadaX", "CoordenadaY", "#Plots");
	}

	function getSites($page = 0, $withTotalPlots = 0){
		
		include_once '../core/core_database.php';
		$query = 'Select SQL_CALC_FOUND_ROWS s.* ' .
				($withTotalPlots == 1 ? ', count(p.plot_id) as totalPlots' : '') . 
				' From site s' . 
				($withTotalPlots == 1 ? ' Left Join plot p On p.site_id = s.site_id Group by s.site_id ' : '');
		return selectDBQuery($query, self::TOTAL_ROWS_SITE, $page);
	}

	function getSiteBy($whereClause, $page = 0){

		include_once '../core/core_database.php';
		$query = 'Select SQL_CALC_FOUND_ROWS s.* From site s Where ' . $whereClause;
		return selectDBQuery($query, self::TOTAL_ROWS_SITE, $page);

	}

	function insertSite($toInsert = array()){

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

		return insertDB(Site::DB_ENTITY_NAME,   $fields, $values);

	}

	function updateSite($toUpdate){

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

		return updateDB(Site::DB_ENTITY_NAME, $set, $where);

	}

	function delete_site($where){

		require_once '../core/core_database.php';

		return deleteDB(Site::DB_ENTITY_NAME, $where);
	}
}
