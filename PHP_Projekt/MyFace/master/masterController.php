<?php

namespace masterController;

require_once 'login/loginController.php';
require_once 'navigater/navigaterController.php';
require_once 'register/regController.php';
require_once 'errorView.php';

	class MasterController{

		/**
		* @var object
		*/
		private $classLoginController;

		/**
		 * @var object
		 */
		private $classFrontPageController;
		
		 /**
		 * @var object
		 */		
		private $classNavigaterController;

		public function __construct() {

			$this->classLoginController = new \loginController\LoginController();
			$this->classNavigaterController = new \navigaterController\NavigaterController();	
			$this->classRegController = new \regController\RegController();
			$this-> masterNavigate();
		}
		
		/**
		 * navigate the user if the user is logged in or not
		 */
		private function masterNavigate(){
			
			try{
				if($this->classLoginController->checkLogin()){
					if($this->classNavigaterController->userWantToLogout()){
						$this->classLoginController->logout();
						$this->classLoginController->showLoginPage();
					}
					else{
						$this->classNavigaterController->checkNavButtons($this->classLoginController->getUser());
					}
				}
				else if($this->classLoginController->userWantToReg()){
					$this->classRegController->register();
				}
				else{
					$this->classLoginController->showLoginPage();
				}
			}
			catch(\Exception $e){
				new \errorView\ErrorView();
			}
		}
	}