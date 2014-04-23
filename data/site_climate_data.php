<?php


function getSiteClimateData(){

	include '../core/core_database.php';
	return selectDB('site_climate_data');
}

function insertSiteClimateData($toInsert = array()){

	require_once '../core/core_database.php';

	$fields = '';
	$values = '';

	foreach ($toInsert as $key => $value) {
		if($value != ""){
			$fields .= '`'. $key . '`, ';
			if($key == 'measureDate'){
				$values .= "'" . $value . "', ";
			}else if($key == 'temperature' || $key == 'precipitation_18o' || $key == 'precipitation' || $key == 'gw_18o' || $key == 'relativeHumidity' || $key == 'par'){
				$values .= '' . str_replace(",", ".", $value) . ', ';
			}else{
				$values .= $value . ', ';
			}
		}
	}

	$fields = substr($fields, 0, -2);
	$values = substr($values, 0, -2);


	return insertDB('site_climate_data',   $fields, $values);

}