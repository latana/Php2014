<?php

namespace loginView;

require_once 'master/masterView.php';
require_once 'settings.php';

class LoginView extends \masterView\MasterView {

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
	public $salt = "aeguagöubaeg";
	
	/**
	 * @var string
	 */
	private static $login;
	
	/**
	 * @var string
	 */
	private static $indexPath;

	public function __construct(){
		
		self::$login = \settings\Settings::$login;
		self::$indexPath = \settings\Settings::$indexPath;
	}
	
	/**
	 * @return string
	 * returns the username input
	 */
	public static function getUserName() {

		if (isset($_POST[self::$userID])) {
			return trim($_POST[self::$userID]);
		}
	}
	
	/**
	 * @return string
	 * returns the username input and uses strip_tags
	 * to delete taggs if there is any
	 */
	public static function getStripUserName() {

		if (isset($_POST[self::$userID])) {
			return strip_tags(trim($_POST[self::$userID]));
		}
	}

	/**
	 * @return string
	 * returns the password input
	 */
	public static function getPassWord() {

		if (isset($_POST[self::$passID])) {
			return trim($_POST[self::$passID]);
		}
	}

	/**
	 * @return bool
	 * return true if the user have clicked on the register link
	 */
	public function getRegLink() {

		if (isset($_GET[self::$RegPage])) {
			return true;
		}
		return false;
	}

	/**
	 * @return bool
	 * returns the true if the user have marked the remeber me box
	 */
	public function autoLogin() {

		if (isset($_POST[self::$autologinID])) {
			return true;
		}
		return false;
	}

	/**
	 * @return string
	 * return the username
	 */
	public function getCookieUserName() {

		if (isset($_COOKIE[self::$cookieUser])) {
			return $_COOKIE[self::$cookieUser];
		}
	}

	/**
	 * @return bool
	 * return true if the cookie is set
	 */

	public function cookieExist() {

		if (isset($_COOKIE[self::$cookieUser]) && (isset($_COOKIE[self::$cookiePass]))) {
			return true;
		}
		return false;
	}

	/**
	 * @param stripUserName string
	 * @param cookiePass string
	 * creates the cookies
	 */

	public function makeCookie($stripUserName, $cookiePass) {

		$cookieTime = time() + 300;

		file_put_contents("cookieTime.txt", "$cookieTime");

		setcookie(self::$cookieUser, $stripUserName, $cookieTime);
		$cryptPass = md5($cookiePass, $this -> salt);

		$value = setcookie(self::$cookiePass, $cryptPass, $cookieTime);
	}

	/**
	 * @param db_userName string
	 * @param cookiePass string
	 * @return bool
	 * validate the time and value of the cookies
	 * if the cookies is fine should return true
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

	/**
	 * unsets the cookies
	 */
	public function destroyCookie() {

		setcookie(self::$cookieUser, "", time() - 3001);
		setcookie(self::$cookiePass, "", time() - 3001);
		unset($_COOKIE[self::$cookieUser]);
		unset($_COOKIE[self::$cookiePass]);
	}

	/**
	 * @return bool
	 * return true if the user click on the login button
	 */

	public static function tryLogin() {

		if (isset($_POST[self::$loginButton])) {
			return true;
		}
		return false;
	}

	/**
	 * creates and render out the login page
	 */
	public function loginPage() {

		$content = "
					<div class='content'>
					<div class='registerlink'>
						<ul>
							<li>
								<a href='?" . self::$RegPage . "'>Register</a>
							</li>
						</ul>
					</div>
					<form class = 'form' action='".self::$indexPath.self::$login."' method='post' enctype='multipart/form-data'>
						<div class = 'divlogged'>
						<h2 class = 'logged' >Not logged in</h2>
						</div>
						<fieldset class = 'fieldset'>
							<legend>Login - Type your username and password</legend>
							<label>Username :</label>
							<input type='text' size='20' name='" . self::$userID . "' 
							id='" . self::$userID . "' value= '" . self::getStripUserName() . "'/>
							<label>Password  :</label>
							<input type='password' size='20' name='" . self::$passID . "'
							id='" . self::$passID . "' value='' />
							<label>Remember me  :</label>
							<input type='checkbox' name='" . self::$autologinID . "' id='" . self::$autologinID . "' />
							<input type='submit' name='" . self::$loginButton . "'  value='Log in' />
						</fieldset>
					</form>
					</div>";

		$this -> rendHTML($content);
	}
}