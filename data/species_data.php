<?php

class Species {

	const TOTAL_ROWS_SPECIES = 10;
	const DB_ENTITY_NAME = 'species';

	function getSpeciesFieldsListConf(){
		return array("#", "Genus", "Species", "Tipo", "Código", "Functional Group", "#Individuos");
	}

	function getSpecies($page = 0, $withTotalIndividuals = 0){
		
		include_once '../core/core_database.php';
		$query = 'Select SQL_CALC_FOUND_ROWS s.* ' .
					($withTotalIndividuals == 1 ? ', count(i.individualCode) as totalIndividuals' : '') . ' 
				From species s ' . 
					($withTotalIndividuals == 1 ? ' Left Join Individual i On i.species_id = s.species_id ' : '') .
					($withTotalIndividuals == 1 ? ' Group by s.species_id ' : '') .
				' Order By s.genus, s.species';
		return selectDBQuery($query, Species::TOTAL_ROWS_SPECIES, $page);
	}

	function getSpeciesBy($whereClause, $page = 0, $withTotalIndividuals = 0){

		include_once '../core/core_database.php';
		$query = 'Select SQL_CALC_FOUND_ROWS s.* ' .
					($withTotalIndividuals == 1 ? ', count(i.individualCode) as totalIndividuals' : '') . ' 
					From species s ' . 
					($withTotalIndividuals == 1 ? ' Left Join Individual i On i.species_id = s.species_id ' : '') . 
					' Where ' . $whereClause . ($withTotalIndividuals == 1 ? ' Group by s.species_id ' : '') .
					' Order By s.genus, s.species';
		return selectDBQuery($query, Species::TOTAL_ROWS_SPECIES, $page);

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

		return insertDB(Species::DB_ENTITY_NAME,   $fields, $values);

	}

	function updateSpecies($toUpdate){

		require_once '../core/core_database.php';

		$set = '';
		foreach ($toUpdate as $key => $value) {
			if($key != 'species_id'){
				$set .= '`'. $key . '` = ' . "'" . $value . "', "; 
			}
		}

		$set = substr($set, 0, -2);
		$where = 'species_id = ' . $toUpdate["species_id"];

		return updateDB(Species::DB_ENTITY_NAME, $set, $where);

	}

	function delete_species($where){

		require_once '../core/core_database.php';

		return deleteDB(Species::DB_ENTITY_NAME, $where);
	}
	
}