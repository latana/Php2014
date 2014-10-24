<?php

namespace sessionModel;

class SessionModel {

	/**
	 * @var string
	 */
	private static $loginSess = "login";

	/**
	 * @var string
	 */
	public static $sessUserName = "sessionUserName";

	/**
	 * @var string
	 */
	private static $sessionController = "Session controller";

	/**
	 * @var string
	 */
	private static $ip = "ip";

	/**
	 * @var string
	 */

	private static $browser = "browser";

	/**
	 * @var string
	 */

	private static $agent = "HTTP_USER_AGENT";

	/**
	 * @var string
	 */
	private static $remote = "REMOTE_ADDR";
	
	/**
	 * @var string
	 */
	private static $creationSuccess = "creationSuccess";
	
	/**
	 * sets the login session to true
	 */
	public static function loginUser() {

		$_SESSION[self::$loginSess] = true;
	}
	
	/**
	 * unsets the login session
	 * unsets the username session
	 */
	public function logout() {

		unset($_SESSION[self::$loginSess]);

		if (isset($_SESSION[self::$sessUserName])) {
			unset($_SESSION[self::$sessUserName]);
		}
	}
	
	/**
	 * creation of a account session
	 */
	public function creationSuccessSession(){
		
		$_SESSION[self::$creationSuccess] = true;
	}
	
	/**
	 * @return bool
	 * returns true if the user just registerd
	 */
	public function checkIfUserJustRegister(){
		
		if(isset($_SESSION[self::$creationSuccess])){
			return true;
		}
		return false;
	}
	
	/**
	 * unset the register session
	 */
	public function unsetSessionMessage(){
		
		unset($_SESSION[self::$creationSuccess]);
	}

	/**
	 * @return bool
	 * return true if the user is logged in
	 */
	public function isUserLogedIn() {

		if (isset($_SESSION[self::$loginSess])) {
			return true;
		}
		return false;
	}

	/**
	 * @param userName string
	 * sets the logged in username in the session
	 */

	public static function rememberWhoIsLoggedIn($userName) {

		$_SESSION[self::$sessUserName] = $userName;
	}

	/**
	 * @return string
	 * return the logged in users username
	 */
	public static function getSessionUserName() {

		if (isset($_SESSION[self::$sessUserName])) {
			return $_SESSION[self::$sessUserName];
		}
	}

	/**
	 * @return bool
	 * validates the session and unset it if it is not
	 * return true if the session is valid
	 */
	public function checkIfLoginIsValid() {

		if (isset($_SESSION[self::$sessionController]) == false) {
			$_SESSION[self::$sessionController] = array();
			$_SESSION[self::$sessionController][self::$browser] = $_SERVER[self::$agent];
			$_SESSION[self::$sessionController][self::$ip] = $_SERVER[self::$remote];
		}
		if ($_SESSION[self::$sessionController][self::$browser] != $_SERVER[self::$agent]) {

			unset($_SESSION[self::$loginSess]);
			return false;
		}
		return true;
	}
}