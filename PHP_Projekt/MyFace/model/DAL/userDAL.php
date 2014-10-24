<?php

namespace userDAL;

require_once 'connectDB.php';
require_once 'objects/user.php';

class UserDAL extends \connectDB\ConnectDB {
	
	/**
	 * @var string
	 */
	private $passSalt = "asfbafuaf32r87g78gfiubaeiyvbeivb";

	/**
	 * @var string
	 */
	private $classUserArray;
	
	/**
	 * @var string
	 */	
	private $classUser;
	
	/**
	 * @var string
	 */	
	private $classImgPreparer;
	
	/**
	 * @var string
	 */	
	private static $userTableName;
	
	/**
	 * @var string
	 */	
	private static $username;
	
	/**
	 * @var string
	 */	
	private static $password;
	
	/**
	 * @var string
	 */	
	private static $profilepic;
	
	/**
	 * @var string
	 */	
	private static $cookiePass;
	
	/**
	 * @var string
	 */	
	private static $uploadPath;
	
	/**
	 * @var string
	 */	
	private static $profilePath;
	
	/**
	 * @var string
	 */	
	private static $tmp_name;
	
	/**
	 * @var string
	 */	
	private static $type;
	
	/**
	 * @var string
	 */	
	private static $defaultPic;

	public function __construct() {

		$this->classImgPreparer = new \imgPreparer\ImgPreparer();
		
		self::$uploadPath = \settings\Settings::$uploadPath;
		self::$profilePath = \settings\Settings::$profilePath;
		self::$tmp_name = \settings\Settings::$tmp_name;
		self::$type = \settings\Settings::$type;
		self::$defaultPic = \settings\Settings::$defaultPic;
		
		self::$cookiePass = \settings\Settings::$cookiePass;
		self::$profilepic = \settings\Settings::$profilepic;
		self::$password = \settings\Settings::$password;
		self::$username = \settings\Settings::$username;
		self::$userTableName = \settings\Settings::$userTableName;
	}
	/**
	 * @param userName string
	 * @return string
	 * returns the username from the database
	 */
	public function getdb_name($userName) {

		if ($this -> OpenDataBase()) {

			$selectSql = "SELECT `".self::$username."` FROM `".self::$userTableName."` WHERE `".self::$username."` = ?";
			$stmt = $this -> GetDataBase() -> prepare($selectSql);
			$stmt -> bind_param("s", $userName);
			$stmt -> execute();
			$stmt -> store_result();
			$stmt -> bind_result($db_userName);
			$stmt -> fetch();
			$this -> CloseDataBase();

			return $db_userName;
		}
	}

	/**
	 * @param userName string
	 * @param passWord string
	 * @return bool
	 * chekcs is the username and password equles any in the database
	 */
	public function login($userName, $passWord) {

		if ($this -> OpenDataBase()) {

			$selectSql = "SELECT `".self::$username."`, `".self::$password."` FROM `".self::$userTableName."` WHERE `".self::$username."` = ?";
			$stmt = $this -> GetDataBase() -> prepare($selectSql);
			$stmt -> bind_param("s", $userName);
			$stmt -> execute();
			$stmt -> store_result();
			$stmt -> bind_result($db_userName, $db_passWord);
			$stmt -> fetch();
			$this -> CloseDataBase();

			if ($db_userName === $userName) {
				if ($db_passWord == md5($passWord, $this->passSalt)) {
					return true;
				}
			}
			else {
				return false;
			}
		}
		return false;
	}
	
	/**
	 * @param userName string
	 * @return bool|string
	 * returns the users cookie password
	 * if the system can't find it, return false
	 */
	public function getCookiePass($userName){
		
		if ($this -> OpenDataBase()) {

			$selectSql = "SELECT `".self::$cookiePass."` FROM `".self::$userTableName."` WHERE `".self::$username."` = ?";
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

	/**
	 * @param userName string
	 * @return bool
	 * if the username is not valid return false
	 */
	public function checkIfValid($userName) {

		if ($this -> OpenDataBase()) {

			$selectSql = "SELECT `".self::$username."` FROM `".self::$userTableName."` WHERE `".self::$username."` = ?";
			$stmt = $this -> GetDataBase() -> prepare($selectSql);
			$stmt -> bind_param("s", $userName);
			$stmt -> execute();
			$stmt -> store_result();
			$stmt -> bind_result($db_userName);
			$stmt -> fetch();

			if (strtolower($userName) === strtolower($db_userName)) {
				return false;
				$this -> CloseDataBase();
			}
		}
		return true;
	}

	/**
	 * @param userName string
	 * @param password string
	 * @param cookiePass string
	 * @return bool
	 * inserts the username and password into the database
	 */
	public function insertUserAndPass($userName, $password, $cookiePass) {

		$cryptPass = md5($password, $this -> passSalt);

		if ($this -> OpenDataBase()) {
			$insertSql = "INSERT INTO ".self::$userTableName." (".self::$username.", ".self::$password.", ".self::$cookiePass.") VALUES (?, ?, ?)";
			$stmt = $this -> GetDataBase() -> prepare($insertSql);
			$stmt -> bind_param("sss", $userName, $cryptPass, $cookiePass);
			$stmt -> execute();
			$stmt -> store_result();
			$stmt -> fetch();
	
			$this -> CloseDataBase();
			return true;
		}
		return false;
	}

	/**
	 * @param newpass string
	 * @param sessUserName string
	 * update the new password
	 */
	public function updateUser($newPass, $sessUserName) {

		$cryptPass = md5($newPass, $this->passSalt);

		if ($this -> OpenDataBase()) {

			$selectSql = "UPDATE `".self::$userTableName."` SET `".self::$password."`= ? WHERE `".self::$username."`= ?";
			$stmt = $this -> GetDataBase() -> prepare($selectSql);
			$stmt -> bind_param('ss', $cryptPass, $sessUserName);
			$stmt -> execute();
		}
		$this -> CloseDataBase();
	}
	
	/**
	 * @param loginUser
	 * @return object
	 * returns one user
	 */
	public function loadUser($loginUser) {

		if ($this -> OpenDataBase()) {
			$selectSql = "SELECT `".self::$username."`, `".self::$password."`, `".self::$profilepic.
						"` FROM `".self::$userTableName."` WHERE `".self::$username."` = ?";
			$stmt = $this -> GetDataBase() -> prepare($selectSql);
			$stmt -> bind_param("s", $loginUser);
			$stmt -> execute();
			$stmt -> store_result();
			$stmt -> bind_result($userName, $password, $profilePic);
			$stmt -> fetch();
			$this -> classUserArray = new \user\UserArray();
			$this -> classUser = new \user\User($userName, $password, $profilePic);
			$this -> classUserArray -> add($this -> classUser);
			
			$this -> CloseDataBase();

			return $this -> classUserArray;
		}
	}
	
	/**
	 * @return object
	 * returns all the users
	 */
	public function loadUsers() {

		if ($this -> OpenDataBase()) {
			$selectSql = "SELECT `".self::$username."`, `".self::$password."`, `".self::$profilepic."` FROM `".self::$userTableName."`";
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
	
	/**
	 * @param loginUser string
	 * @param profilePicName
	 * changes the profilepicture in the database
	 */
	public function changeProfilePicture($loginUser, $profilePicName) {

		if ($this -> OpenDataBase()) {
			$selectSql = "UPDATE `".self::$userTableName."` SET `".self::$profilepic."`= ? WHERE `".self::$username."` = ?";
			$stmt = $this -> GetDataBase() -> prepare($selectSql);
			$stmt -> bind_param('ss', $profilePicName, $loginUser);
			$stmt -> execute();
			$this -> CloseDataBase();
		}
	}
	
	/**
	 * @param loginUser
	 * creates the profilepicture
	 */
	public function createProfilePic($loginUser){
		
		$defaultPath = self::$uploadPath ."/". self::$defaultPic;
		$profilePath = self::$uploadPath."/".$loginUser."/".self::$profilePath."/";
		
		$this->classImgPreparer->createFolder($profilePath, $loginUser);
			
		copy($defaultPath, $profilePath. self::$defaultPic);
	}
	
	/**
	 * @param pic array
	 * @param loginUser string
	 * @return newPicName string
	 * save the new profile picture
	 */
	public function saveProfilePic($pic, $loginUser) {

		$folderPath = self::$uploadPath."/" . $loginUser . "/".self::$profilePath."/";

		$this->classImgPreparer->createFolder($folderPath, $loginUser);

		$newPicName = $this->classImgPreparer->setPicName($folderPath, $pic);
		
		move_uploaded_file($pic[self::$tmp_name], $folderPath . $newPicName);
		
		$imgPath = $folderPath . $newPicName;

		$dest_imagex = 50;

		$this -> classImgPreparer->makeThumbnail($imgPath, $pic[self::$type], $dest_imagex);

		return $newPicName;
	}
}