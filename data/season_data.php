<?php

define("TOTAL_ROWS_SEASON", 10);
define("ORDER_BY_SEASON", "s.season_id");

function getSeasonFieldsListConf(){

	return array("#", "Código", "Início (Europa)", "Fim (Europa)", "#Campanhas");
}

function getSeasons($page = 0, $withTotalCampaings = 0){
	
	require_once '../core/core_database.php';
	$query = 'Select s.*' . 
			($withTotalCampaings == 1 ? ', count(sc.sampling_campaign_id) as totalCampaigns' : '') . 
			' From season s ' .
			($withTotalCampaings == 1 ? ' Left Join sampling_campaign sc On sc.season_id = s.season_id ' : '') . 
			($withTotalCampaings == 1 ? ' Group by s.season_id ' : '') .
			' Order by ' . ORDER_BY_SEASON;
	return selectDBQuery($query, TOTAL_ROWS_SEASON, $page);
}

function getSeasonBy($whereClause, $page = 0, $withTotalCampaings = 0){

	require_once '../core/core_database.php';
	$query = 'Select SQL_CALC_FOUND_ROWS s.* ' . 
			($withTotalCampaings == 1 ? ', count(sc.sampling_campaign_id) as totalCampaigns' : '') . 
			' From season s ' .
			($withTotalCampaings == 1 ? ' Left Join sampling_campaign sc On cs.season_id = s.season_id ' : '') . 
			' Where ' . $whereClause . ($withTotalCampaings == 1 ? ' Group by s.season_id ' : '') .
			 ' Order By ' . ORDER_BY_SEASON;
	return selectDBQuery($query, TOTAL_ROWS_SEASON, $page);

}

function insertSeason($toInsert = array()){

	require_once '../core/core_database.php';

	$fields = '';
	$values = '';

	foreach ($toInsert as $key => $value) {
		if($value != ""){
			$fields .= '`'. $key . '`, ';
			$values .= "'" . $value . "', ";
		}
	}

	$fields = substr($fields, 0, -2);
	$values = substr($values, 0, -2);


	return insertDB('season',   $fields, $values);

}

function updateSeason($toUpdate){

	require_once '../core/core_database.php';

	$set = '';
	foreach ($toUpdate as $key => $value) {
		if($key != 'season_id' && $value != ""){
			$set .= '`'. $key . '` = ' . "'" . $value . "', "; 
		}
	}

	$set = substr($set, 0, -2);
	$where = '`season_id` = ' . $toUpdate["season_id"];


	return updateDB('season', $set, $where);
}

function delete_season($where){

	require_once '../core/core_database.php';

	return deleteDB('season', $where);
}