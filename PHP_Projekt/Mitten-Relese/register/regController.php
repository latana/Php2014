<?php

namespace regController;

require_once 'regView.php';
require_once 'model/userModel.php';

class RegController {

	/**
	 * innehåller klassen View i register mappen
	 */
	private $regViewClass;

	/**
	 * innehåller klassen database i database mappen
	 */
	private $dataBaseClass;

	private $regModelClass;
	
	private $cookiePass;

	public function __construct() {

		$this -> regViewClass = new \viewregister\ViewRegister();
		$this -> classUserModel = new \userModel\UserModel();
		$this -> userName = $this -> regViewClass -> getRegName();
		$this -> strippUserName = trim($this -> regViewClass -> getStripRegName());
		$this -> password = trim($this -> regViewClass -> getRegPass());
		$this -> repRegPass = $this -> regViewClass -> getRepRegPass();
		$this->cookiePass = $this->regViewClass->getRandomCookieString();
	}

	public function register() {

		if ($this -> regViewClass -> TryReg()) {
			if ($this -> UserAndPassController()) {
				if ($this -> classUserModel -> checkInputLength($this -> userName, $this -> password)) {
					if ($this -> classUserModel -> CheckIfValid($this -> userName)) {
						if ($this -> classUserModel -> InsertUserAndPass($this -> userName, $this -> password, $this->cookiePass)) {
							$this -> regViewClass -> setMessage(\viewregister\ViewRegister::CREATION_SUCCESS);
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

	private function userAndPassController() {

		if ($this -> userName !== $this -> strippUserName) {
			$this -> regViewClass -> setMessage(\viewregister\ViewRegister::NO_VALID_USERNAME);
			return false;
		} else if ($this -> password !== $this -> repRegPass) {
			$this -> regViewClass -> setMessage(\viewregister\ViewRegister::PASSWORD_NOT_MATCH);
			return false;
		}
		return true;
	}
}