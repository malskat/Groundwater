<?php

define("TOTAL_ROWS_USER", 10);
define("ORDER_BY_USER", "b.biologyst_id");

function getUserFieldsListConf(){

	return array("#", "Nome", "Email", "Data de criação");
}

function getUsers($page = 0){
	
	require_once '../core/core_database.php';
	$query = 'Select SQL_CALC_FOUND_ROWS b.*
			From biologyst b
			Order by ' . ORDER_BY_USER;
	return selectDBQuery($query, TOTAL_ROWS_USER, $page);
}

function getUserBy($whereClause, $page = 0){

	require_once '../core/core_database.php';
	$query = 'Select SQL_CALC_FOUND_ROWS b.* 
			 	From biologyst b
			 	Where ' . $whereClause .
			 ' Order By ' . ORDER_BY_USER;
	return selectDBQuery($query, TOTAL_ROWS_USER, $page);

}

function insertUser($toInsert = array()){

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


	return insertDB('biologyst',   $fields, $values);

}

function updateUser($toUpdate){

	require_once '../core/core_database.php';

	$set = '';
	foreach ($toUpdate as $key => $value) {
		if($key != 'biologyst_id' && $value != ""){
			$set .= '`'. $key . '` = ' . "'" . $value . "', "; 
		}
	}

	$set = substr($set, 0, -2);
	$where = '`biologyst_id` = ' . $toUpdate["biologyst_id"];


	return updateDB('biologyst', $set, $where);
}

function delete_user($where){

	require_once '../core/core_database.php';
	return deleteDB('biologyst', str_replace("user_id", "biologyst_id", $where));
}