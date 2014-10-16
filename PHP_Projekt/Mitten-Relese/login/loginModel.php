<?php

namespace loginModel;

class LoginModel {

	/**
	 * @var string
	 */
	public static $admin = "Admin";

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
	private $batCave = "hemlight";
	
	public static function loginUser() {

		$_SESSION[self::$loginSess] = true;

	}

	public function logout() {

		unset($_SESSION[self::$loginSess]);

		if (isset($_SESSION[self::$sessUserName])) {

			unset($_SESSION[self::$sessUserName]);
		}

	}

	/**
	 * @return bool, Kontrollerar ifall sessionen
	 * är satt och retunerar i så fall true
	 */
	public function isUserLogedIn() {

		if (isset($_SESSION[self::$loginSess])) {
			return true;
		}
		return false;
	}

	/**
	 * @param userName string
	 * sätter in användarens namn som value i session
	 * för att hålla reda på vem som är inloggad
	 */

	public static function rememberWhoIsLoggedIn($userName) {

		$_SESSION[self::$sessUserName] = $userName;
	}

	/**
	 * @return string, retunerar användaren som
	 * är inloggad.
	 */
	public static function getSessionUserName() {

		if (isset($_SESSION[self::$sessUserName])) {
			return $_SESSION[self::$sessUserName];
		}
	}

	/**
	 * @return bool, Kontrollerar ifall sessionen stämmer,
	 * Om inte så tas sessionen bort och true retuneras
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
	
	public function getAdmin(){
		
		return self::$admin;
	}
}