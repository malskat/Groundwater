<?php

require_once '/gObject.php';

class Season extends gObject {


	function __construct (){
		$this->_entityName = 'season';
		$this->_fieldList = array("#", "Código", "Início (Europa)", "Fim (Europa)", "#Campanhas");
		$this->_totalRows = 10;
		$this->_orderBy = 's.' . $this->_entityName . '_id';
	}

	function getSeasons($page = 0, $withTotalCampaings = 0){
		
		require_once '../core/core_database.php';
		$query = 'Select s.*' . 
				($withTotalCampaings == 1 ? ', count(sc.sampling_campaign_id) as totalCampaigns' : '') . 
				' From season s ' .
				($withTotalCampaings == 1 ? ' Left Join sampling_campaign sc On sc.season_id = s.season_id ' : '') . 
				($withTotalCampaings == 1 ? ' Group by s.season_id ' : '') .
				' Order by ' . $this->_orderBy;
		return CoreDatabase::selectDBQuery($query, $this->_totalRows, $page);
	}

	function getSeasonBy($whereClause, $page = 0, $withTotalCampaings = 0){

		require_once '../core/core_database.php';
		$query = 'Select SQL_CALC_FOUND_ROWS s.* ' . 
				($withTotalCampaings == 1 ? ', count(sc.sampling_campaign_id) as totalCampaigns' : '') . 
				' From season s ' .
				($withTotalCampaings == 1 ? ' Left Join sampling_campaign sc On cs.season_id = s.season_id ' : '') . 
				' Where ' . $whereClause . ($withTotalCampaings == 1 ? ' Group by s.season_id ' : '') .
				 ' Order By ' . $this->_orderBy;
		return CoreDatabase::selectDBQuery($query, $this->_totalRows, $page);

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


		return CoreDatabase::insertDB($this->_entityName,   $fields, $values);

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


		return CoreDatabase::updateDB($this->_entityName, $set, $where);
	}

}