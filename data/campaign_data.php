<?php

require_once 'gObject.php';

class Campaign extends gObject {	

	function __construct (){
		$this->_entityName = 'sampling_campaign';
		$this->_fieldList = array("#", "Title", "Site", "Season", "Begin", "End");
		$this->_totalRows = 10;
		$this->_orderBy = $this->_entityName . '_id';
	}

	function getCampaigns($page = 0){
		
		require_once '../core/core_database.php';
		$query = 'Select SQL_CALC_FOUND_ROWS sc.*, s.title as siteTitle,  se.code as seasonCode
					From sampling_campaign sc
					Join site s On s.site_id = sc.site_id
					Join season se On se.season_id = sc.season_id 
					Order By sc.' . $this->_orderBy; 
		return CoreDatabase::selectDBQuery($query, $this->_totalRows, $page);
	}

	function getCampaignBy($whereClause, $page = 0){

		require_once '../core/core_database.php';
		$query = 'Select SQL_CALC_FOUND_ROWS sc.*, s.title as siteTitle,  se.code as seasonCode
					From sampling_campaign sc
					Join site s On s.site_id = sc.site_id
					Join season se On se.season_id = sc.season_id 
					Where ' . $whereClause . '
					Order By sc.' . $this->_orderBy;
		return CoreDatabase::selectDBQuery($query, $this->_totalRows, $page);

	}

	function insert($toInsert = array()){

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

		return CoreDatabase::insertDB($this->_entityName, $fields, $values);
	}


	function update($toUpdate){

		require_once '../core/core_database.php';

		$set = '';
		foreach ($toUpdate as $key => $value) {
			if($key != 'sampling_campaign_id' && $value != ""){
				$set .= '`'. $key . '` = ' . "'" . $value . "', "; 
			}
		}

		$set = substr($set, 0, -2);
		$where = '`sampling_campaign_id` = ' . $toUpdate["sampling_campaign_id"];


		return CoreDatabase::updateDB($this->_entityName, $set, $where);
	}

	function delete($where){

		require_once '../core/core_database.php';
		$where = str_replace("campaign", "sampling_campaign", $where);
		
		return CoreDatabase::deleteDB($this->_entityName, $where);
	}
}
