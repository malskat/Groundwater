<?php

require_once '/gObject.php';

class Individual extends gObject {

	function __construct (){
		$this->_entityName = 'individual';
		$this->_fieldList = array("Código", "Espécie (Genus-Species)", "Plot", "#Eco-Fisio", "#Struture");
		$this->_totalRows = 10;
	}

	function getIndividualPlotSpecies ($page = 0, $withTotals = 0){

		require_once '../core/core_database.php';

		$query = 'Select SQL_CALC_FOUND_ROWS i.*, s.species, s.genus, p.code as plotCode, st.title as siteTitle ' .
					($withTotals == 1 ? ', count(ef.individualCode) as totalEcoFisio' : '') .
					($withTotals == 1 ? ', str.struture_id' : '') .
					' From individual i 
					Join plot p on p.plot_id = i.plot_id
					Join site st on st.site_id = p.site_id
					Join species s on s.species_id = i.species_id ' . 
					($withTotals == 1 ? 'left Join struture str On str.individualCode = i.individualCode ' : '') .
					($withTotals == 1 ? 'left Join eco_fisio ef On ef.individualCode = i.individualCode Group By i.individualCode' : '') . 
					' Order by i.individualCode';

		return CoreDatabase::selectDBQuery($query, $this->_totalRows, $page);

	}

	function getIndividualBy ($whereClause, $page = 0, $withTotals = 0){

		require_once '../core/core_database.php';

		$query = 'Select SQL_CALC_FOUND_ROWS i.*, s.species, s.genus, p.code as plotCode, st.title as siteTitle ' .
					($withTotals == 1 ? ', count(ef.individualCode) as totalEcoFisio' : '') .
					($withTotals == 1 ? ', str.struture_id' : '') .
					' From individual i 
					Join plot p on p.plot_id = i.plot_id
					Join site st on st.site_id = p.site_id
					Join species s on s.species_id = i.species_id ' . 
					($withTotals == 1 ? 'left Join eco_fisio ef On ef.individualCode = i.individualCode ' : '') . 
					($withTotals == 1 ? 'left Join struture str On str.individualCode = i.individualCode ' : '') .
					' Where ' . $whereClause . ($withTotals == 1 ? ' Group By i.individualCode' : '') . 
					' Order By i.individualCOde';
					
		return CoreDatabase::selectDBQuery($query, $this->_totalRows, $page);

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

		return CoreDatabase::insertDB($this->_entityName,   $fields, $values);
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

		return CoreDatabase::updateDB($this->_entityName, $set, $where);
	}

	function delete ($where){

		require_once '../core/core_database.php';
		return CoreDatabase::deleteDB($this->_entityName, str_replace("individual_id", "individualCode", $where));
	}
	
}