<?php

require_once 'gObject.php';

class Individual extends gObject {

	function __construct (){
		$this->_entityName = 'individual';
		$this->_fieldList = array("Code", "Species (Genus-Species)", "Plot", "Eco-Physiology", "Structure", "Unispec - Reflectance");
		$this->_totalRows = 10;
	}

	function getIndividual ($page = 0, $withTotals = 0) {

		require_once '../core/core_database.php';

		$query = 'Select SQL_CALC_FOUND_ROWS i.*, s.species, s.genus, p.code as plotCode, st.site_id, st.title as siteTitle ' .
					($withTotals == 1 ? ', (select count(1) from eco_fisio ef where ef.individualCode = i.individualCode) as totalEcoFisio ' : '') .
					($withTotals == 1 ? ', str.struture_id' : '') .
					($withTotals == 1 ? ', (select count(1) from individual_reflectance ir where ir.individualCode =  i.individualCode)  as totalReflectance ' : '') .
					' From individual i 
					Join plot p on p.plot_id = i.plot_id
					Join site st on st.site_id = p.site_id
					Join species s on s.species_id = i.species_id ' . 
					($withTotals == 1 ? 'left Join struture str On str.individualCode = i.individualCode ' : '') .
					' Order by i.individualCode';

		return CoreDatabase::selectDBQuery($query, $this->_totalRows, $page);

	}

	function getIndividualBy ($whereClause, $page = 0, $withTotals = 0) {

		require_once '../core/core_database.php';

		$query = 'Select SQL_CALC_FOUND_ROWS i.*, s.species, s.genus, p.code as plotCode, st.site_id, st.title as siteTitle ' .
					($withTotals == 1 ? ', (select count(1) from eco_fisio ef where ef.individualCode = i.individualCode) as totalEcoFisio' : '') .
					($withTotals == 1 ? ', str.struture_id' : '') .
					($withTotals == 1 ? ', (select count(1) from individual_reflectance ir where ir.individualCode =  i.individualCode)  as totalReflectance ' : '') .
					' From individual i 
					Join plot p on p.plot_id = i.plot_id
					Join site st on st.site_id = p.site_id
					Join species s on s.species_id = i.species_id ' . 
					($withTotals == 1 ? 'left Join struture str On str.individualCode = i.individualCode ' : '') .
					' Where ' . $whereClause . ($withTotals == 1 ? ' Group By i.individualCode' : '') . 
					' Order By i.individualCOde';
					
		return CoreDatabase::selectDBQuery($query, $this->_totalRows, $page);

	}

	function insert ($toInsert = array()) {

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

		$response = null;
		try {

			$response = CoreDatabase::insertDB($this->_entityName,   $fields, $values);

		} catch (PDOException $ex) {
			throw $ex;
		}

		return $response;
	}

	function update ($toUpdate) {

		require_once '../core/core_database.php';

		$set = '';
		foreach ($toUpdate as $key => $value) {
			if($key != 'individualCode'){
				$set .= '`'. $key . '` = ' . "'" . $value . "', "; 
			}
		}

		$set = substr($set, 0, -2);
		$where = "`individualCode` = '" . $toUpdate["individualCode"] . "'";

		return CoreDatabase::updateDB($this->_entityName, $set, $where);
	}

	function delete ($where){

		require_once '../core/core_database.php';
		return CoreDatabase::deleteDB($this->_entityName, str_replace("individual_id", "individualCode", $where));
	}
	
}