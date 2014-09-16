<?php

class CoreDatabase {

	public static function selectDB($table, $totalRows = 0, $page = 0){

		include PROJECT_PATH . 'init.php';
		
		try {

			$Database->beginTransaction();

			$objsToReturn = array();

			if($page > -1) {

				$offset = ($page > 0 ? (($page - 1) * $totalRows) : 0);
				
				$contentSQL = "SELECT SQL_CALC_FOUND_ROWS * FROM " . $table . ($totalRows > 0 ? " Limit " . $offset . ", " . $totalRows . ";" : "");
				$contentRS = $Database->query($contentSQL);

				$totalRS = $Database->query('SELECT FOUND_ROWS() as totalRecords');
				if ($totalRS->rowCount() > 0) {
					$objsToReturn[] = $totalRS->fetch();
				}

			} else {
				$contentRS = $Database->query("SELECT SQL_CALC_FOUND_ROWS * FROM " . $table . ";");
			}

			if ($contentRS->rowCount() > 0) {
				while ($item = $contentRS->fetch()) {
					$objsToReturn[] = $item;
				}
			}
					
			$Database->commit();
			$Database = null;

		} catch (PDOException $ex) {
			$Database->rollBack();
			echo ($ex->getMessage());
			die;
		}

		return $objsToReturn;
	}

	public static function selectDBQuery($query, $totalRows = 0, $page = 0){
		include PROJECT_PATH . 'init.php';
		try {

			$Database->beginTransaction();

			$objsToReturn = array();

			if($page > -1) {
				$offset = ($page > 0 ? (($page - 1) * $totalRows) : 0);

				$contentRS = $Database->query($query . ($totalRows > 0 ? " Limit " . $offset . ", " . $totalRows . ";" : ";"));
				$totalRS = $Database->query('SELECT FOUND_ROWS() as totalRecords');

				if ($totalRS->rowCount() > 0) {
					$objsToReturn[] = $totalRS->fetch();
				}
			} else {
				$contentRS = $Database->query($query);
			}


			if ($contentRS->rowCount() > 0) {
				while ($item = $contentRS->fetch()) {
					$objsToReturn[] = $item;
				}
			}
					
			$Database->commit();
			$Database = null;

		} catch (PDOException $ex) {
			$Database->rollBack();
			echo ($ex->getMessage());
			die;
		}

		return $objsToReturn;
	}

	public static function insertDB($table, $fields, $values){

		include PROJECT_PATH . '/init.php';

		$toReturn = array();

		try {

			$insertSQL = 'INSERT INTO ' . $table . '(' . $fields . ') VALUES (' . $values . ');';

			$Database->beginTransaction();
			$toReturn['_success_'] = $Database->exec($insertSQL);
			$toReturn['_id_'] = $Database->lastInsertId();


			$Database->commit();
			$Database = null;

		} catch (PDOException $ex) {
			$Database->rollBack();
			echo ($ex->getMessage());
			die;
		}

		return $toReturn;
	}

	public static function updateDB($table, $set, $where){

		include PROJECT_PATH . 'init.php';

		$toReturn = array();

		try{

			$updateSQL = ' UPDATE ' . $table . ' SET ' . $set . ' WHERE ' . $where . ';';
			$Database->beginTransaction();
			$toReturn['_success_'] = $Database->exec($updateSQL);

			$Database->commit();
			$Database = null;
		} catch (PDOException $ex) {
			$Database->rollBack();
			echo ($ex->getMessage());
			die;
		}

		return $toReturn;
	}

	public static function deleteDB ($table, $where){

		include PROJECT_PATH . 'init.php';

		try{

			$success = -1;

			if(isset($where) && $where != "") {
				$updateSQL = ' Delete From ' . $table . ' Where ' . $where . ';';
				$Database->beginTransaction();
				
				$success = $Database->exec($updateSQL);

				$Database->commit();
				$Database = null;
			} else {
				echo 'o where do delete vinha vazio';
				die;
			}

			

		} catch (PDOException $ex) {
			$Database->rollBack();
			echo ($ex->getMessage());
			die;
		}

		return $success;

	}

	public static function callBD ($routine) {

		include PROJECT_PATH . 'init.php';

		try {

			$Database->beginTransaction();

			$success = $Database->exec('CALL ' . $routine);

			$Database->commit();
			$Database = null;

		} catch (PDOException $ex) {
			$Database->rollBack();
			echo ($ex->getMessage());
			die;
		}

		return $success;
	}
}
