<?php

require_once  PROJECT_PATH . 'data/gObject.php';

class UserPermission extends gObject {


	function __construct() {
		$this->_entityName = 'biologyst_permission';
		$this->_fieldList = array("#", "Name", "Email", "Creation Date", "Last Login");
		$this->_totalRows = 10;
		$this->_orderBy = $this->_entityName . '_id';
   }


   function getUserPermissionBy ($whereClause) {

		require_once PROJECT_PATH . 'core/core_database.php';

		$query = 'Select *
					From biologyst_permission
					Where ' . $whereClause;
			
		return CoreDatabase::selectDBQuery($query, $this->_totalRows, $page = -1);
   }

}