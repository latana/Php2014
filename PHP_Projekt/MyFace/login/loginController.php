<?php

namespace loginController;

require_once 'login/loginView.php';
require_once 'login/sessionModel.php';
require_once 'model/userModel.php';

class LoginController {

	public function __construct() {

		$this -> classLoginView = new \loginView\LoginView();
		$this -> classSessionModel = new \sessionModel\SessionModel();
		$this->classUserModel = new \userModel\UserModel();
	}

	/**
	 * @return bool
	 * returns true if the user is logged in any way
	 */
	public function checkLogin() {

		if ($this -> checkIfLoggedIn()) {
			return true;
		}
		else if ($this -> checkRememberMe()) {
			return true;
		}
		else if ($this -> classLoginView -> tryLogin()) {

			if ($this -> checkUserAndPass()) {
				$this -> login();
				return true;
			}
		}
	}
	
	/**
	 * logges out the user
	 */
	public function Logout() {

		$this -> classLoginView -> destroyCookie();
		$this -> classSessionModel -> Logout();
	}

	/**
	 * check if a register message is needed
	 * and show's the loginPage
	 */
	public function showLoginPage() {
	
		if($this->classSessionModel->checkIfUserJustRegister()){
			$this -> classLoginView -> setMessage(\loginView\LoginView::CREATION_SUCCESS);
			$this->classSessionModel->unsetSessionMessage();
		}
		$this -> classLoginView -> loginPage();
	}

	/**
	 * @return string
	 * returns the logged in username
	 */
	public function getUser() {

		return $this -> classSessionModel -> getSessionUserName();
	}

	/**
	 * @return bool
	 * checks the session
	 */
	public function checkIfLoggedIn() {

		if ($this -> classSessionModel -> isUserLogedIn()) {
			if ($this -> classSessionModel -> checkIfLoginIsValid()) {
				return true;
			}
			else {
				$this -> classLoginView -> setMessage(\loginView\LoginView::WRONG_SESSION);
			}
			return false;
		}
	}

	/**
	 * @return bool
	 * checks the cookies
	 */
	public function checkRememberMe() {

		if ($this -> classLoginView -> cookieExist()) {

			$db_userName = $this -> classUserModel -> getdb_name($this -> classLoginView -> getCookieUserName());
			
			if ($this -> classLoginView -> checkIfValidCookie($db_userName, $this -> classUserModel -> getCookiePass($db_userName))) {

				$this -> classSessionModel -> loginUser();
				$this -> classSessionModel -> rememberWhoIsLoggedIn($db_userName);
				return true;
			}
			else {
				$this -> classLoginView -> setMessage(\loginView\LoginView::WRONG_COOKIE);
				$this -> classLoginView -> destroyCookie();
			}
		}
	}

	/**
	 * @return bool
	 * return true if the username and password is correct
	 */
	private function checkUserAndPass() {

		if ($this -> classLoginView -> getStripUserName() == null) {

			$this -> classLoginView -> setMessage(\loginView\LoginView::MISSING_USERNAME);
		}
		else if ($this -> classLoginView -> getPassWord() == null) {

			$this -> classLoginView -> setMessage(\loginView\LoginView::MISSING_PASSWORD);
		}
		else if ($this -> classLoginView -> getUserName() != $this -> classLoginView -> getStripUserName()) {

			$this -> classLoginView -> setMessage(\loginView\LoginView::NOT_ALLOWED_USERNAME);
		}
		else if ($this -> classUserModel -> login($this -> classLoginView -> getStripUserName(), $this -> classLoginView -> getPassWord())) {
			return true;
		}
		else {
			$this -> classLoginView -> setMessage(\loginView\LoginView::WRONG_USERNAME_PASSWORD);
		}
	}

	/**
	 * check if cookies needs to be created
	 * and logges in the user
	 */
	private function login() {

		if ($this -> classLoginView -> autoLogin()) {
			
			$cookiePass = $this -> classUserModel -> getCookiePass($this->classLoginView->getStripUserName());
			
			$this -> classLoginView -> makeCookie($this -> classLoginView -> getStripUserName(), $cookiePass);
		}
		$this -> classSessionModel -> loginUser();
		$this -> classSessionModel -> rememberWhoIsLoggedIn($this -> classLoginView -> getStripUserName());
	}

	/**
	 * @return bool
	 * returns true if the user want's to register
	 */
	public function userWantToReg() {

		if ($this -> classLoginView -> getRegLink()) {
			return true;
		}
	}
}