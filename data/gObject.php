<?php

class gObject {
	
	protected $_entityName;
	protected $_fieldList;
	protected $_totalRows;
	protected $_orderBy;

	function __construct ($entityName, $fieldList){
		$this->_entityName = $entityName;
		$this->_fieldList = $fieldList;
		$this->_totalRows = 10;
		$this->_orderBy = $this->_entityName . '_id';
	}

	function getEntityName (){
		return $this->_entityName;
	}

	function getTotalRows (){
		return $this->_totalRows;
	}

	function getFieldList (){
		return $this->_fieldList;
	}	

	function getOrderBy (){
		return $this->_orderBy;
	}

	function getObjects ($page = 0){
		require_once '../core/core_database.php';
		if (isset($this->_entityName)) {
			return CoreDatabase::selectDB($this->_entityName, $this->_totalRows, $page);
		} else {
			return array();
		}
	}

	function getObjectsBy ($where, $page = 0) {
		require_once '../core/core_database.php';
		$query = 'Select SQL_CALC_FOUND_ROWS * From ' . $this->_entityName . ' Where ' . $where;

		return CoreDatabase::selectDBQuery($query, $this->_totalRows, $page);
	}

	function insert ($toInsert = array()){

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

	function update ($toUpdate){

		require_once '../core/core_database.php';

		$set = '';
		foreach ($toUpdate as $key => $value) {
			if($key != $this->_entityName . '_id'){
				$set .= '`'. $key . '` = ' . "'" . $value . "', "; 
			}
		}

		$set = substr($set, 0, -2);
		$where = $this->_entityName . '_id = ' . $toUpdate[$this->_entityName . '_id'];

		return CoreDatabase::updateDB($this->_entityName, $set, $where);

	}

	function delete ($where){

		require_once '../core/core_database.php';

		return CoreDatabase::deleteDB($this->_entityName, $where);
	}
}