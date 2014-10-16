<?php

namespace loginController;

require_once 'login/loginView.php';
require_once 'login/loginModel.php';
require_once 'model/userModel.php';

class LoginController {

	public function __construct() {

		$this -> classLoginView = new \loginView\LoginView();
		$this -> classLoginModel = new \loginModel\LoginModel();
		$this->classUserModel = new \userModel\UserModel();

	}

	public function checkLogin() {

		if ($this -> checkIfLoggedIn()) {
			return true;
		} else if ($this -> checkRememberMe()) {
			return true;
		} else if ($this -> classLoginView -> tryLogin()) {
			if ($this -> checkUserAndPass()) {
				$this -> login();
				return true;
			}
		}
	}

	public function Logout() {

		$this -> classLoginView -> destroyCookie();
		$this -> classLoginModel -> Logout();
		$this -> classLoginView -> setMessage(\loginView\LoginView::USER_LOG_OUT);
	}

	public function showLoginPage() {

		$this -> classLoginView -> loginPage();
	}

	public function getUser() {

		return $this -> classLoginModel -> getSessionUserName();
	}

	public function checkIfLoggedIn() {

		if ($this -> classLoginModel -> isUserLogedIn()) {
			if ($this -> classLoginModel -> checkIfLoginIsValid()) {
				return true;
			} else {
				$this -> classLoginView -> setMessage(\loginView\LoginView::WRONG_SESSION);
			}
			return false;
		}
	}

	public function checkRememberMe() {

		if ($this -> classLoginView -> cookieExist()) {

			$db_userName = $this -> classUserModel -> getdb_name($this -> classLoginView -> getCookieUserName());
			if ($this -> classLoginView -> checkIfValidCookie($db_userName, $this -> classUserModel -> getCookiePass($db_userName))) {

				$this -> classLoginModel -> loginUser();
				$this -> classLoginModel -> rememberWhoIsLoggedIn($db_userName);
				return true;
			} else {
				$this -> classLoginView -> setMessage(\loginView\LoginView::WRONG_COOKIE);
				$this -> classLoginView -> destroyCookie();
			}
		}
	}

	private function checkUserAndPass() {

		if ($this -> classLoginView -> getStripUserName() == null) {

			$this -> classLoginView -> setMessage(\loginView\LoginView::MISSING_USERNAME);
		} else if ($this -> classLoginView -> getPassWord() == null) {

			$this -> classLoginView -> setMessage(\loginView\LoginView::MISSING_PASSWORD);
		} else if ($this -> classLoginView -> getUserName() != $this -> classLoginView -> getStripUserName()) {

			$this -> classLoginView -> setMessage(\loginView\LoginView::NOT_ALLOWED_USERNAME);
		} else if ($this -> classUserModel -> login($this -> classLoginView -> getStripUserName(), $this -> classLoginView -> getPassWord())) {
			return true;
		} else {
			$this -> classLoginView -> setMessage(\loginView\LoginView::WRONG_USERNAME_PASSWORD);
		}
	}

	private function login() {

		if ($this -> classLoginView -> autoLogin()) {
			
			$cookiePass = $this -> classUserModel -> getCookiePass($this->classLoginView->getStripUserName());
			
			$this -> classLoginView -> makeCookie($this -> classLoginView -> getStripUserName(), $cookiePass);
		}
		$this -> classLoginModel -> loginUser();
		$this -> classLoginModel -> rememberWhoIsLoggedIn($this -> classLoginView -> getStripUserName());
	}

	public function userWantToReg() {

		if ($this -> classLoginView -> getRegLink()) {
			return true;
		}
	}
}