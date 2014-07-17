<?php

require_once 'gObject.php';

class Structure extends gObject {

	function __construct (){
		$this->_entityName = 'struture';
		$this->_fieldList = array();
		$this->_totalRows = 10;
	}

	function insert ($toInsert = array()){

		require_once '../core/core_database.php';

		$fields = '';
		$values = '';

		foreach ($toInsert as $key => $value) {
			if($value != ""){
				$fields .= '`'. $key . '`, ';

				if ($key == 'individualCode' || $key == 'samplingDate' || $key == 'file') {
					$values .= "'" . $value . "', ";
				} else {
					$values .= '' . str_replace(",", ".", $value) . ', ';
				}
			}
		}

		$fields = substr($fields, 0, -2);
		$values = substr($values, 0, -2);

		return CoreDatabase::insertDB($this->_entityName, $fields, $values);
	}


	function update ($toUpdate = array()){

		require_once '../core/core_database.php';

		$set = '';
		foreach ($toUpdate as $key => $value) {
			if($value != "" && $key != $this->_entityName . '_id') {
				if ($key == 'individualCode' || $key == 'samplingDate' || $key == 'file') {
						$set .= '`'. $key . '` = ' . "'" . $value . "', "; 
				} else {
					$set .= '`'. $key . '` = ' . str_replace(",", ".", $value) . ', ';
				}
			}
		}

		$set = substr($set, 0, -2);
		$where = $this->_entityName . "_id = " . $toUpdate[$this->_entityName . '_id'];

		return CoreDatabase::updateDB($this->_entityName, $set, $where);
	}

	function delete ($where) {
		//por motivos historicos (erro na criacao da tabela no mysql) fazemos aqui este replace
		$where = str_replace("structure_id", "struture_id", $where);
		return parent::delete($where);
	}

}