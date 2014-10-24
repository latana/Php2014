<?php
namespace userModel;

require_once 'DAL/userDAL.php';
require_once 'DAL/imgPreparer.php';

class UserModel {

	/**
	 * @var object
	 */
	private $userDAL;

	public function __construct() {

		$this -> userDAL = new \userDAL\UserDAL();
		$this->imgPreparer = new \imgPreparer\ImgPreparer();
	}
	
	/**
	 * @param pic array
	 * @return bool
	 */
	public function checkPicSize($pic){
		
		if($this->imgPreparer->checkPicSize($pic)){
			return true;
		}
		return false;
	}

	/**
	 * @return object
	 * returns all the users
	 */
	public function loadUsers() {

		return $this -> userDAL -> loadUsers();
	}
	
	/**
	 * @param loginUser string
	 * @return object
	 * returns one user
	 */
	public function loadUser($loginUser) {
		
		if(is_string($loginUser)){
			return $this -> userDAL -> loadUser($loginUser);
		}
		return false;
	}
	
	/**
	 * @param userName string
	 * @param password string
	 * @return bool
	 * check the length of username and password
	 */
	public function checkInputLength($userName, $password) {

		if(is_string($userName) && is_string($password)){

			if (strlen($userName) < 3 || strlen($userName) > 25) {
				return false;
			}
			if (strlen($password) < 6 || strlen($userName) > 25) {
				return false;
			}
			return true;
		}
		return false;
	}

	/**
	 * @param username string
	 * @return bool
	 */
	public function checkIfValid($userName) {
		
		if(is_string($userName)){
			
			if(strlen($userName) > 0){
				return $this -> userDAL -> checkIFValid($userName);
			}
		}
		return true;
	}

	/**
	 * @param userName string
	 * @param password string
	 * @param cookiePass string
	 * @return bool
	 */
	public function insertUserAndPass($userName, $password, $cookiePass) {
		
		if(is_string($userName) && is_string($password) && is_string($cookiePass)){
			
			$this->userDAL->createProfilePic($userName);
			return $this -> userDAL -> insertUserAndPass($userName, $password, $cookiePass);
		}
		return false;
	}
	
	/**
	 * @param userName string
	 * @param password string
	 * @return bool
	 */
	public function login($userName, $password) {

		if(is_string($userName) && is_string($password)){
			if ($this -> userDAL -> login($userName, $password)) {
				return true;
			}
		}
		return false;
	}

	/**
	 * @param userName string
	 * @return string|bool 
	 */
	public function getdb_name($userName) {

		if(is_string($userName)){
			return $this -> userDAL -> getdb_name($userName);
		}
		return false;
	}
	
	/**
	 * @param userName string
	 * @return string|bool
	 */
	public function getCookiePass($userName){
		
		if(is_string($userName)){
			return $this->userDAL->getCookiePass($userName);
		}
		return false;
	}

	/**
	 * @param newPass string
	 * @return bool
	 */
	public function checkUpdatePassLength($newPass) {
		
		if(is_string($newPass)){
			if (6 > (strlen($newPass))) {
				return true;
			}
		}
		return false;
	}

	/**
	 * @param password string
	 * @param userName string
	 * @return bool
	 */
	public function updateUser($password, $userName) {
		
		if(is_string($password) && is_string($userName)){
			$this -> userDAL -> updateUser($password, $userName);
		}
		return false;
	}
	
	/**
	 * @param pic array
	 * @param loginUser string
	 * @return string|bool
	 */
	public function saveProfilePic($pic, $loginUser){
		
		if(is_string($loginUser)){
			return $this->userDAL->saveProfilePic($pic, $loginUser);
		}
		return false;
	}

	/**
	 * @param userName string
	 * @param profilePicName string
	 * @return bool
	 */
	public function changeProfilePicture($userName, $profilePicName) {
		
		if(is_string($userName) && is_string($profilePicName)){
			$this -> userDAL -> changeProfilePicture($userName, $profilePicName);
		}
		return false;
	}
	
	/**
	 * @param pic array
	 * @return bool
	 */
	public function validatePic($pic) {

		if($this->imgPreparer->validatePic($pic)){
			return true;
		}
		return false;
	}
}