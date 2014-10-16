<?php
namespace userModel;

require_once 'DAL/userDAL.php';
require_once 'login/loginModel.php';

class UserModel {

	private $userDAL;

	public function __construct() {

		$this -> userDAL = new \userDAL\UserDAL();
	}
	
	public function isLoggedInAdmin($loginUser){
		
		if($loginUser == \loginModel\LoginModel::$admin){
			return true;
		}
		return false;
	}

	public function loadUsers() {

		return $this -> userDAL -> loadUsers();
	}
	
	public function checkInputLength($userName, $password) {

		if ((strlen($userName) < 3) && (strlen($password) < 6)) {
			return false;
		} else if (strlen($userName) < 3) {
			return false;
		} else if (strlen($password) < 6) {
			return false;
		}
		return true;
	}

	public function checkIfValid($userName) {

		return $this -> userDAL -> checkIFValid($userName);
	}

	public function insertUserAndPass($userName, $password, $cookiePass) {

		return $this -> userDAL -> insertUserAndPass($userName, $password, $cookiePass);
	}
	
	public function login($userName, $password) {

		if ($this -> userDAL -> login($userName, $password)) {
			return true;
		}
		return false;
	}

	public function getdb_name($userName) {

		return $this -> userDAL -> getdb_name($userName);
	}
	
	public function getCookiePass($userName){
		
		return $this->userDAL->getCookiePass($userName);
	}

	public function checkUpdatePassLength($newPass) {

		if (6 > (strlen($newPass))) {
			
			return true;
		}
		return false;
	}

	public function updateUser($password, $userName) {

		$this -> userDAL -> updateUser($password, $userName);
	}
	

}
