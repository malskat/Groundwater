<?php

require_once '/gObject.php';

$passHashCompatible = function_exists('password_hash');

//validar se a funcao existe, porque em php 5.3 nao existe, portanto usamos uma lib:
if (!$passHashCompatible) {
	require_once('../libs/password.php');
}

class User extends gObject {

	public $hashOptions;

	function __construct() {

		$this->_entityName = 'biologyst';
		$this->_fieldList = array("#", "Nome", "Email", "Data de criação", "Último login");
		$this->_totalRows = 10;
		$this->_orderBy = $this->_entityName . '_id';

		$this->hashOptions = array(
						'cost' => 11,
						'salt' => mcrypt_create_iv(22, MCRYPT_DEV_URANDOM),
					);
   }

	function getUsers($page = 0){
		
		require_once '../core/core_database.php';
		$query = 'Select SQL_CALC_FOUND_ROWS b.*
				From biologyst b
				Order by b.' . $this->_orderBy;
		return CoreDatabase::selectDBQuery($query, $this->_totalRows, $page);
	}

	function getUserBy($whereClause, $page = 0){

		require_once '../core/core_database.php';
		$query = 'Select SQL_CALC_FOUND_ROWS b.*
				 	From biologyst b
				 	Where ' . $whereClause .
				 ' Order By b.' . $this->_orderBy;
		return CoreDatabase::selectDBQuery($query, $this->_totalRows, $page);

	}

	function validateLogin($email, $password) {

		$logged = false;

		$user = $this->getUserBy("email = '" . $email . "'", -1);

		if (count($user) == 1){

			$passwordFromPost = trim($password);
			$hashedPassword = password_hash($passwordFromPost, PASSWORD_BCRYPT, $this->hashOptions);

			if (password_verify($passwordFromPost, $user[0]->password)) {
			    $logged = $user;
			}
		}


		return $logged;
	}

	function insert($toInsert = array()){

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

	function update($toUpdate){

		require_once '../core/core_database.php';

		$set = '';
		foreach ($toUpdate as $key => $value) {
			if($key != 'biologyst_id' && $key != 'email' && $value != ""){
				$set .= '`'. $key . '` = ' . "'" . $value . "', "; 
			}
		}

		$set = substr($set, 0, -2);
		$where = '`biologyst_id` = ' . $toUpdate["biologyst_id"];

		return CoreDatabase::updateDB($this->_entityName, $set, $where);
	}

	function delete($where){

		require_once '../core/core_database.php';
		return CoreDatabase::deleteDB($this->_entityName, str_replace("user_id", "biologyst_id", $where));
	}

	function updateLastLogin ($biologyst_id) {

		require_once '../core/core_database.php';

		return CoreDatabase::callBD('update_last_login(' . $biologyst_id . ')');

	}

}
