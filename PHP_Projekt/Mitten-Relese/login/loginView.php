<?php

namespace loginView;

require_once 'master/basicView.php';

class LoginView extends \basicView\BasicView {

	
	/**
	 * @var string
	 */
	private static $RegPage = "register";

	/**
	 * @var string
	 */
	private static $userID = "user";

	/**
	 * @var string
	 */
	private static $passID = "pass";

	/**
	 * @var string
	 */
	private static $autologinID = "autologin";

	/**
	 * @var string
	 */
	private static $loginButton = "loginbutton";

	/**
	 * @var string
	 */
	private static $cookieUser = "cookieUser";

	/**
	 * @var string
	 */
	private static $cookiePass = "cookiePass";

	/**
	 * @var string
	 */
	public static $login = "?login";

	/**
	 * @var string
	 */
	public $salt = "aeguagöubaeg";

	/**
	 * @return string, retunerar innehållet av vad
	 * användaren matat som användarnamn.
	 */

	public static function getUserName() {

		if (isset($_POST[self::$userID])) {

			return trim($_POST[self::$userID]);
		}
	}

	public static function getStripUserName() {

		if (isset($_POST[self::$userID])) {
			return strip_tags(trim($_POST[self::$userID]));
		}
	}

	/**
	 * @return string, retunerar innehållet av
	 * vad användaren matat in som lösenord.
	 */

	public static function getPassWord() {

		if (isset($_POST[self::$passID])) {

			return trim($_POST[self::$passID]);
		}
	}

	public function getRegLink() {

		if (isset($_GET[self::$RegPage])) {
			return true;
		}
		return false;
	}

	/**
	 * @return bool, retunerar true om "Håll mig inloggad" boxen är markerad
	 */

	public function autoLogin() {

		if (isset($_POST[self::$autologinID])) {
			return true;
		}
		return false;
	}

	/**
	 * @return string, retunerar cookieUser
	 */
	public function getCookieUserName() {

		if (isset($_COOKIE[self::$cookieUser])) {

			return $_COOKIE[self::$cookieUser];
		}
	}
	
		/**
	 * @return string, retunerar cookiePass
	 */
	public function getCookiePass() {

		if (isset($_COOKIE[self::$cookieUser])) {

			return $_COOKIE[self::$cookieUser];
		}
	}

	/**
	 * @return bool, retunerar true om kakorna är satta
	 */

	public function cookieExist() {

		if (isset($_COOKIE[self::$cookieUser]) && (isset($_COOKIE[self::$cookiePass]))) {
			return true;
		}
		return false;
	}

	/**
	 * @param userName string
	 * @param batCave string
	 * skapar kakorna, sätter tid, namn och value
	 */

	public function makeCookie($stripUserName, $cookiePass) {

		$cookieTime = time() + 3000;

		file_put_contents("cookieTime.txt", "$cookieTime");

		setcookie(self::$cookieUser, $stripUserName, $cookieTime);
		$cryptPass = md5($cookiePass, $this -> salt);

		$value = setcookie(self::$cookiePass, $cryptPass, $cookieTime);
	}

	/**
	 * @param userName string
	 * @param batCave string
	 * @return bool, kollar av kakornas tid och
	 * value och retunerar true om det stämmer
	 */

	public function checkIfValidCookie($db_userName, $cookiePass) {

		$timeFile = file_get_contents("cookieTime.txt");

		if ($timeFile > time()) {

			if ($_COOKIE[self::$cookieUser] == $db_userName && $_COOKIE[self::$cookiePass] == md5($cookiePass, $this -> salt)) {

				return true;
			}
		}
		return false;
	}

	public function destroyCookie() {

		setcookie(self::$cookieUser, "", time() - 3001);
		setcookie(self::$cookiePass, "", time() - 3001);
		unset($_COOKIE[self::$cookieUser]);
		unset($_COOKIE[self::$cookiePass]);
	}

	/**
	 * @return bool, retunerar true om man trycker på login knappen
	 */

	public static function tryLogin() {

		if (isset($_POST[self::$loginButton])) {

			return true;
		}
		return false;
	}

	public function loginPage() {

		$content = "
					<div class='content'>
					<a class = 'registerlink' href='?" . self::$RegPage . "'>Register</a>
					<form class = 'form' action='.".self::$login."' method='post' enctype='multipart/form-data'>
						<div class = 'divlogged'>
						<h2 class = 'logged' >Not logged in</h2>
						</div>
						<fieldset class = 'fieldset'>
							<legend>Login - Type your username and password</legend>
							<label for='userID' >Username :</label>
							<input type='text' size='20' name='" . self::$userID . "' 
							id='" . self::$userID . "' value= '" . self::getStripUserName() . "'/>
							<label for='passID' >Password  :</label>
							<input type='password' size='20' name='" . self::$passID . "'
							id='" . self::$passID . "' value='' />
							<label for='autologinID' >Remember me  :</label>
							<input type='checkbox' name='" . self::$autologinID . "' id='" . self::$autologinID . "' />
							<input type='submit' name='" . self::$loginButton . "'  value='Log in' />
						</fieldset>
					</form>
					</div>";

		$this -> rendHTML($content);
	}
}