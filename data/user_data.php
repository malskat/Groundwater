<?php

$passHashCompatible = function_exists('password_hash');

//validar se a funcao existe, porque em php 5.3 nao existe, portanto usamos uma lib:
if (!$passHashCompatible) {
	require_once('../libs/password.php');
}

class User {

	const TOTAL_ROWS_USER = 10;
	const ORDER_BY_USER = 'b.biologyst_id';

	function getUserFieldsListConf(){

		return array("#", "Nome", "Email", "Data de criação", "Último login");
	}

	function getUsers($page = 0){
		
		require_once '../core/core_database.php';
		$query = 'Select SQL_CALC_FOUND_ROWS b.*
				From biologyst b
				Order by ' . self::ORDER_BY_USER;
		return selectDBQuery($query, self::TOTAL_ROWS_USER, $page);
	}

	function getUserBy($whereClause, $page = 0){

		require_once '../core/core_database.php';
		$query = 'Select SQL_CALC_FOUND_ROWS b.*
				 	From biologyst b
				 	Where ' . $whereClause .
				 ' Order By ' . self::ORDER_BY_USER;
		return selectDBQuery($query, self::TOTAL_ROWS_USER, $page);

	}

	function validateLogin($email, $password) {

		$logged = false;

		$user = $this->getUserBy("email = '" . $email . "'", -1);

		if (count($user) == 1){

			$options = array(
						'cost' => 11,
						'salt' => mcrypt_create_iv(22, MCRYPT_DEV_URANDOM),
					);

			$passwordFromPost = trim($password);
			$hashedPassword = password_hash($passwordFromPost, PASSWORD_BCRYPT, $options);

			if (password_verify($passwordFromPost, $user[0]->password)) {
			    $logged = $user;
			}
		}


		return $logged;
	}

	function insertUser($toInsert = array()){

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


		return insertDB('biologyst',   $fields, $values);

	}

	function updateUser($toUpdate){

		require_once '../core/core_database.php';

		$set = '';
		foreach ($toUpdate as $key => $value) {
			if($key != 'biologyst_id' && $value != ""){
				$set .= '`'. $key . '` = ' . "'" . $value . "', "; 
			}
		}

		$set = substr($set, 0, -2);
		$where = '`biologyst_id` = ' . $toUpdate["biologyst_id"];

		return updateDB('biologyst', $set, $where);
	}

	function delete_user($where){

		require_once '../core/core_database.php';
		return deleteDB('biologyst', str_replace("user_id", "biologyst_id", $where));
	}

	function updateLastLogin ($biologyst_id) {

		require_once '../core/core_database.php';
		return callBD('update_last_login(' . $biologyst_id . ')');

	}

}
