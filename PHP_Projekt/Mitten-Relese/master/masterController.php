<?php

namespace masterController;

require_once 'login/loginController.php';
require_once 'master/pageNavigater.php';
require_once 'register/regController.php';

	class MasterController{

		/**
		 * innehåller klassen logincontroller
		 */

		private $classLoginController;

		/**
		 * innehåller klassen pageController
		 */
		private $classFrontPageController;
		
		private $classPageNavigater;

		public function __construct() {

			$this->classLoginController = new \loginController\LoginController();
			$this->classPageNavigater = new \pageNavigater\PageNavigater();	
			$this->classRegController = new \regController\RegController();
			$this-> navigate();
		}
		
		private function navigate(){
			
			if($this->classLoginController->checkLogin()){
				if($this->classPageNavigater->userWantToLogout()){
					$this->classLoginController->logout();
					$this->classLoginController->showLoginPage();
				}
				else{
					$this->classPageNavigater->checkNavButtons($this->classLoginController->getUser());
				}
			}
			else if($this->classLoginController->userWantToReg()){
				$this->classRegController->register();
			}
			else{
				$this->classLoginController->showLoginPage();
			}
		}
	}