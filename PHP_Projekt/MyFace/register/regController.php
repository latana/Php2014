<?php

namespace regController;

require_once 'regView.php';
require_once 'model/userModel.php';
require_once 'login/sessionModel.php';

class RegController {

	/**
	 * @var object
	 */
	private $regViewClass;

	/**
	 * @var object
	 */
	private $classSessionModel;
	
	/**
	 * @var string
	 */
	private $userName;
	
	/**
	 * @var string
	 */
	private $strippUserName;
	
	/**
	 * @var string
	 */
	private $password;
	
	/**
	 * @var string
	 */
	private $stripPassword;
	
	/**
	 * @var string
	 */
	private $repRegPass;
	
	/**
	 * @var string
	 */
	private $cookiePass;

	public function __construct() {

		$this -> regViewClass = new \viewregister\ViewRegister();
		$this -> classUserModel = new \userModel\UserModel();
		$this -> classSessionModel = new \sessionModel\SessionModel();
		
		$this -> userName = $this -> regViewClass -> getRegName();
		$this -> strippUserName = trim($this -> regViewClass -> getStripRegName());
		$this -> password = trim($this -> regViewClass -> getRegPass());
		$this -> stripPassword = trim($this->regViewClass->getStripRegPass());
		$this -> repRegPass = $this -> regViewClass -> getRepRegPass();
		$this -> cookiePass = $this->regViewClass->getRandomCookieString();
	}

	/**
	 * handels the registration proccess
	 * and shows the registretion page
	 */
	public function register() {

		if ($this -> regViewClass -> TryReg()) {
			if ($this -> UserAndPassController()) {
				if ($this -> classUserModel -> checkInputLength($this -> userName, $this -> password)) {
					if ($this -> classUserModel -> CheckIfValid($this -> userName)) {
						if ($this -> classUserModel -> InsertUserAndPass($this -> userName, $this -> stripPassword, $this->cookiePass)) {
							$this->classSessionModel->creationSuccessSession();
							$this->regViewClass->navigateToLogin();
						}
					}
					else{
						$this -> regViewClass -> setMessage(\viewregister\ViewRegister::USERNAME_ALREADY_TAKEN);
					}
				}
				else {
					$this -> regViewClass -> setMessage(\viewregister\ViewRegister::BOTH_TO_SHORT);
				}
			}
		}
		$this -> regViewClass -> ShowRegisterBox();
	}

	/**
	 * validate the username and password
	 */
	private function userAndPassController() {

		if ($this -> userName !== $this -> strippUserName) {
			$this -> regViewClass -> setMessage(\viewregister\ViewRegister::NO_VALID_USERNAME);
			return false;
		}
		else if($this -> stripPassword !== $this -> password){
			$this -> regViewClass -> setMessage(\viewregister\ViewRegister::UPDATE_NO_VALID_PASS);
			return false;
		}
		else if ($this -> password !== $this -> repRegPass) {
			$this -> regViewClass -> setMessage(\viewregister\ViewRegister::PASSWORD_NOT_MATCH);
			return false;
		}
		return true;
	}
}