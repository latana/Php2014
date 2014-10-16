<?php

namespace userDAL;

require_once 'connectDB.php';
require_once 'objects/user.php';

class UserDAL extends \connectDB\ConnectDB {
	
	private $passSalt = "asfbafuaf32r87g78gfiubaeiyvbeivb";

	private $classUserArray;
	
	private $classUser;

	public function __construct() {

		$this -> classUserArray = new \user\UserArray();
		$this -> classUserArray = new \user\UserArray();
	}
	/**
	 * @param userName string
	 * @return bool, hämtar ut ett användarnamn
	 */
	public function getdb_name($userName) {

		if ($this -> OpenDataBase()) {

			$selectSql = 'SELECT * FROM `User` WHERE `Username` = ?';
			$stmt = $this -> GetDataBase() -> prepare($selectSql);
			$stmt -> bind_param("s", $userName);
			$stmt -> execute();
			$stmt -> store_result();
			$stmt -> bind_result($db_userName, $db_passWord, $db_profilePic, $db_CookiePass);
			$stmt -> fetch();
			$this -> CloseDataBase();

			return $db_userName;
		}
	}

	/**
	 * @param userName string
	 * @param passWord string
	 * @return bool, kontrollerar ifall det användaren
	 * matat in stämmer och retunerar i så fall true
	 */
	public function login($userName, $passWord) {

		if ($this -> OpenDataBase()) {

			$selectSql = 'SELECT * FROM `User` WHERE `Username` = ?';
			$stmt = $this -> GetDataBase() -> prepare($selectSql);
			$stmt -> bind_param("s", $userName);
			$stmt -> execute();
			$stmt -> store_result();
			$stmt -> bind_result($db_userName, $db_passWord, $db_profilePic, $db_CookiePass);
			$stmt -> fetch();
			$this -> CloseDataBase();

			if ($stmt -> num_rows == 1) {
				if ($db_passWord == md5($passWord, $this->passSalt)) {
					return true;
				}
			} else {
				return false;
			}
		}
		return false;
	}
	
	public function getCookiePass($userName){
		
		if ($this -> OpenDataBase()) {

			$selectSql = 'SELECT `CookiePass` FROM `User` WHERE `Username` = ?';
			$stmt = $this -> GetDataBase() -> prepare($selectSql);
			$stmt -> bind_param("s", $userName);
			$stmt -> execute();
			$stmt -> store_result();
			$stmt -> bind_result($dbCookiePass);
			$stmt -> fetch();
			$this -> CloseDataBase();

			if ($stmt -> num_rows == 1) {
				return $dbCookiePass;
				
			} else {
				return false;
			}
		}
		return false;
	}

	public function checkIfValid($userName) {

		if ($this -> OpenDataBase()) {

			$selectSql = 'SELECT `Username` FROM `User` WHERE `Username` = ?';
			$stmt = $this -> GetDataBase() -> prepare($selectSql);
			$stmt -> bind_param("s", $userName);
			$stmt -> execute();
			$stmt -> store_result();
			$stmt -> bind_result($db_userName);
			$stmt -> fetch();

			if ($userName == $db_userName) {
				return false;
				$this -> CloseDataBase();
			}
		}
		return true;
	}

	public function insertUserAndPass($userName, $password, $cookiePass) {

		$cryptPass = md5($password, $this -> passSalt);

		$insertSql = "INSERT INTO User (Username, Password, CookiePass) VALUES (?, ?, ?)";
		$stmt = $this -> GetDataBase() -> prepare($insertSql);
		$stmt -> bind_param("sss", $userName, $cryptPass, $cookiePass);
		$stmt -> execute();
		$stmt -> store_result();
		$stmt -> fetch();

		$this -> CloseDataBase();
		return true;
	}

	/**
	 * @param newpass, string
	 * @param sessUserName, string
	 * Uppdaterar det nya lösenordet
	 */
	public function updateUser($newPass, $sessUserName) {

		$cryptPass = md5($newPass, $this->passSalt);

		if ($this -> OpenDataBase()) {

			$selectSql = "UPDATE `User` SET `Password`= ? WHERE `Username`= ?";
			$stmt = $this -> GetDataBase() -> prepare($selectSql);
			$stmt -> bind_param('ss', $cryptPass, $sessUserName);
			$stmt -> execute();
		}
		$this -> CloseDataBase();
	}
	
	public function loadUsers() {

		if ($this -> OpenDataBase()) {
			$selectSql = "SELECT `Username`, `Password`, `ProfilePic` FROM `User`";
			$stmt = $this -> GetDataBase() -> prepare($selectSql);
			$stmt -> execute();
			$stmt -> store_result();
			$stmt -> bind_result($userName, $password, $profilePic);

			$this -> classUserArray = new \user\UserArray();

			while ($stmt -> fetch()) {
				$this -> classUser = new \user\User($userName, $password, $profilePic);
				$this -> classUserArray -> add($this -> classUser);
			}
			$this -> CloseDataBase();

			return $this -> classUserArray;
		}
	}
}