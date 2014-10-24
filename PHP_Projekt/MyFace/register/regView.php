<?php

namespace viewregister;

require_once 'master/masterView.php';
require_once 'settings.php';

	class ViewRegister extends \masterView\MasterView{
		
		/**
		 * @var string
		 */
		public static $regUser = "register";

		/**
		 * @var string
		 */
		public static $regName = "RegName";

		/**
		 * @var string
		 */
		public static $regPass = "RegPass";

		/**
		 * @var string
		 */
		public static $repRegPass = "RepRegPass";

		/**
		 * @var string
		 */
		private static $back = "index.php";

		/**
		 * @var string
		 */
		public static $regButton = "Register";
		
		/**
		 * @var integer
		 */
		private $length = 50;
		

		 /**
		 * @var string
		 */		
		private $charset='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';

		 /**
		 * @var string
		 */		
		private $str = '';

		 /**
		 * @var string
		 */		
		private static $location;
	
		 /**
		 * @var string
		 */	
		private static $PHP_SELF;
		
		public function __construct(){
			
			self::$location = \settings\Settings::$location;
			self::$PHP_SELF = \settings\Settings::$PHP_SELF;
		}
		
		/**
		 * navigate to index.php
		 */
		public function navigateToLogin(){
			
			header(self::$location.$_SERVER[self::$PHP_SELF]);
		}

		/**
		 * @return string
		 * return the username input
		 */
		public static function getRegName(){

			if(isset($_POST[self::$regName])){
				return $_POST[self::$regName];
			}
		}

		/**
		 * @return string
		 * returns the username input without taggs
		 */
		public static function getStripRegName(){

			if(isset($_POST[self::$regName])){
				return strip_tags($_POST[self::$regName]);
			}
		}
		
		/**
		 * @return string
		 * returns the password input without taggs
		 */
		public static function getStripRegPass(){

			if(isset($_POST[self::$regPass])){	
				return strip_tags($_POST[self::$regPass]);
			}
		}
		
		/**
		 * @return string
		 * returns the password input without taggs
		 */
		public static function getRegPass(){

			if(isset($_POST[self::$regPass])){	
				return $_POST[self::$regPass];
			}
		}

		/**
		 * @return string
		 * returns the password input
		 */
		public static function getRepRegPass(){

			if(isset($_POST[self::$repRegPass])){	
				return $_POST[self::$repRegPass];
			}
		}
		/**
		 * @return string
		 * returns a random string
		 */
		public function getRandomCookieString(){
			
		    $count = strlen($this->charset);
		    while ($this->length--) {
		        $this->str .= $this->charset[mt_rand(0, $count-1)];
		    }
		    return $this->str;
		}

		/**
		 * @return bool
		 * return true if the user tries to register
		 */
		public static function tryReg(){

			if(isset($_POST[self::$regButton])){
				return true;
			}
			return false;
		}

		/**
		 * render the register page
		 */
		public function showRegisterBox(){

			$content = 
			
			"<div class = 'content'>
		    	<div class = 'divform'>
		    		<div class='registerlink'>
			    		<ul>
							<li>
								<a href='" . self::$back . "'>Back</a>
							</li>
						</ul>	
					</div>
				</div>
				<div class = 'divlogged'>
					<h2 class = 'logged'>Not logged in</h2>
				</div>
				<form method='post'>
					<fieldset class = 'regfieldset'>
						<legend>Write your username and password</legend>
						<label>Username :</label>
						<input type='text' size='20' name='".self::$regName."' id='UserNameID' value='".self::GetStripRegName()."' />
						<label>Password  :</label>
						<input type='password' size='20' name='" . self::$regPass . "' id='PasswordID' value='' />
						<label>Repeat password  :</label>
						<input type='password' size='20' name='" . self::$repRegPass . "' id='RepeatPasswordID' value='' />
						<input type='submit' name='".self::$regButton."'  value='".self::$regButton."' />
					</fieldset>
				</form>
			</div>";

			$this->rendHTML($content);
		}
	} 