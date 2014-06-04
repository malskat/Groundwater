<?php

class Individual {
	
	const TOTAL_ROWS_INDIVIDUAL = 10;
	const DB_ENTITY_NAME = 'individual';

	function getIndividualFieldsListConf (){

		return array("Código", "Phenological Type", "Espécie (Genus-Species)", "Plot", "#Eco-Fisio");
	}

	function getIndividuals ($page = 0){
		
		include '../core/core_database.php';
		return selectDB('individual', self::TOTAL_ROWS_INDIVIDUAL, $page);
	}

	function getIndividualPlotSpecies ($page = 0, $withTotals = 0){

		require_once '../core/core_database.php';
		$query = 'Select SQL_CALC_FOUND_ROWS i.*, s.species, s.genus, p.code as plotCode, st.title as siteTitle ' .
					($withTotals == 1 ? ', count(ef.individualCode) as totalEcoFisio' : '') .
					' From individual i 
					Join plot p on p.plot_id = i.plot_id
					Join site st on st.site_id = p.site_id
					Join species s on s.species_id = i.species_id ' . 
					($withTotals == 1 ? 'left Join eco_fisio ef On ef.individualCode = i.individualCode Group By i.individualCode' : '') . 
					' Order by i.individualCode';
		return selectDBQuery($query, self::TOTAL_ROWS_INDIVIDUAL, $page);

	}

	function getIndividualBy ($whereClause, $page = 0, $withTotals = 0){

		require_once '../core/core_database.php';
		$query = 'Select SQL_CALC_FOUND_ROWS i.*, s.species, s.genus, p.code as plotCode, st.title as siteTitle ' .
					($withTotals == 1 ? ', count(ef.individualCode) as totalEcoFisio' : '') .
					' From individual i 
					Join plot p on p.plot_id = i.plot_id
					Join site st on st.site_id = p.site_id
					Join species s on s.species_id = i.species_id ' . 
					($withTotals == 1 ? 'left Join eco_fisio ef On ef.individualCode = i.individualCode ' : '') . 
					' Where ' . $whereClause . ($withTotals == 1 ? ' Group By i.individualCode' : '') . 
					' Order By i.individualCOde';
		return selectDBQuery($query, self::TOTAL_ROWS_INDIVIDUAL, $page);

	}

	function insertIndividual ($toInsert = array()){

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

		return insertDB(Individual::DB_ENTITY_NAME,   $fields, $values);
	}

	function updateIndividual ($toUpdate){

		require_once '../core/core_database.php';

		$set = '';
		foreach ($toUpdate as $key => $value) {
			if($key != 'individualCode'){
				$set .= '`'. $key . '` = ' . "'" . $value . "', "; 
			}
		}

		$set = substr($set, 0, -2);
		$where = "`individualCode` = '" . $toUpdate["individualCode"] . "'";

		return updateDB(Individual::DB_ENTITY_NAME, $set, $where);
	}

	function delete_individual ($where){

		require_once '../core/core_database.php';
		return deleteDB(Individual::DB_ENTITY_NAME, str_replace("individual_id", "individualCode", $where));
	}
	
}