<?php

define("TOTAL_ROWS_CAMPAIGN", 10);
define("ORDER_BY_CAMPAIGN", "sampling_campaign_id");

function getCampaignFieldsListConf(){

	return array("#", "Título", "Local", "Época", "Início", "Fim");
}

function getCampaigns($page = 0){
	
	require_once '../core/core_database.php';
	$query = 'Select SQL_CALC_FOUND_ROWS sc.*, s.title as siteTitle,  se.code as seasonCode
				From sampling_campaign sc
				Join site s On s.site_id = sc.site_id
				Join season se On se.season_id = sc.season_id 
				Order By ' . ORDER_BY_CAMPAIGN;
	return selectDBQuery($query, TOTAL_ROWS_CAMPAIGN, $page);
}

function getCampaignBy($whereClause, $page = 0){

	require_once '../core/core_database.php';
	$query = 'Select SQL_CALC_FOUND_ROWS sc.*, s.title as siteTitle,  se.code as seasonCode
				From sampling_campaign sc
				Join site s On s.site_id = sc.site_id
				Join season se On se.season_id = sc.season_id 
				Where ' . $whereClause . '
				Order By ' . ORDER_BY_CAMPAIGN;
	return selectDBQuery($query, TOTAL_ROWS_CAMPAIGN, $page);

}

function insertCampaign($toInsert = array()){

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

	return insertDB('sampling_campaign',   $fields, $values);
}


function updateCampaign($toUpdate){

	require_once '../core/core_database.php';

	$set = '';
	foreach ($toUpdate as $key => $value) {
		if($key != 'sampling_campaign_id' && $value != ""){
			$set .= '`'. $key . '` = ' . "'" . $value . "', "; 
		}
	}

	$set = substr($set, 0, -2);
	$where = '`sampling_campaign_id` = ' . $toUpdate["sampling_campaign_id"];


	return updateDB('sampling_campaign', $set, $where);
}

function delete_campaign($where){

	require_once '../core/core_database.php';
	$where = str_replace("campaign", "sampling_campaign", $where);
	
	return deleteDB('sampling_campaign', $where);
}