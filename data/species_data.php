<?php

require_once '/gObject.php';

class Species extends gObject {

	function __construct (){
		$this->_entityName = 'species';
		$this->_fieldList = array("#", "Genus", "Species", "Tipo", "Código", "Functional Group", "#Individuos");
		$this->_totalRows = 10;
	}

	function getSpecies($page = 0, $withTotalIndividuals = 0){
		
		include_once '../core/core_database.php';
		$query = 'Select SQL_CALC_FOUND_ROWS s.* ' .
					($withTotalIndividuals == 1 ? ', count(i.individualCode) as totalIndividuals' : '') . ' 
				From species s ' . 
					($withTotalIndividuals == 1 ? ' Left Join Individual i On i.species_id = s.species_id ' : '') .
					($withTotalIndividuals == 1 ? ' Group by s.species_id ' : '') .
				' Order By s.genus, s.species';
		return CoreDatabase::selectDBQuery($query, $this->_totalRows, $page);
	}

	function getSpeciesBy($whereClause, $page = 0, $withTotalIndividuals = 0){

		include_once '../core/core_database.php';
		$query = 'Select SQL_CALC_FOUND_ROWS s.* ' .
					($withTotalIndividuals == 1 ? ', count(i.individualCode) as totalIndividuals' : '') . ' 
					From species s ' . 
					($withTotalIndividuals == 1 ? ' Left Join Individual i On i.species_id = s.species_id ' : '') . 
					' Where ' . $whereClause . ($withTotalIndividuals == 1 ? ' Group by s.species_id ' : '') .
					' Order By s.genus, s.species';
		return CoreDatabase::selectDBQuery($query, $this->_totalRows, $page);

	}

	function insertSpecies($toInsert = array()){

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

	function updateSpecies($toUpdate){

		require_once '../core/core_database.php';

		$set = '';
		foreach ($toUpdate as $key => $value) {
			if($key != 'species_id' && $value != ""){
				$set .= '`'. $key . '` = ' . "'" . $value . "', "; 
			}
		}

		$set = substr($set, 0, -2);
		$where = 'species_id = ' . $toUpdate["species_id"];

		return CoreDatabase::updateDB($this->_entityName, $set, $where);

	}
	
}