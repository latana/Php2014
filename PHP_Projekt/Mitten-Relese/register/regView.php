<?php

namespace viewregister;

require_once 'master/basicView.php';

	class ViewRegister extends \basicView\BasicView{

		
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
		public static $regButton = "Registrera";
		
		private $length = 50;
		
		private $charset='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
		
		private $str = '';

		public static function getRegName(){

			if(isset($_POST[self::$regName])){
				return $_POST[self::$regName];
			}
		}

		public static function getStripRegName(){

			if(isset($_POST[self::$regName])){
				return strip_tags($_POST[self::$regName]);
			}
		}

		public static function getRegPass(){

			if(isset($_POST[self::$regPass])){	
				return strip_tags($_POST[self::$regPass]);
			}
		}

		public static function getRepRegPass(){

			if(isset($_POST[self::$repRegPass])){	
				return $_POST[self::$repRegPass];
			}
		}
		
		public function getRandomCookieString(){
			
		    $count = strlen($this->charset);
		    while ($this->length--) {
		        $this->str .= $this->charset[mt_rand(0, $count-1)];
		    }
		    return $this->str;
		}

		public static function tryReg(){

			if(isset($_POST[self::$regButton])){
				return true;
			}
			return false;
		}

		public function showRegisterBox(){

			$content = 
			
			"<div class = 'content'>
		    <div class = 'divform'>
			<a class = 'registerlink' href='" . self::$back . "'>Tillbaka</a>
			</div>
			<div class = 'divlogged'>
			<h2 class = 'logged'>Not logged in</h2>
			</div>
				<form method='post'>
					<fieldset class = 'fieldset'>
						<legend>Write your username and password</legend>
						<label for='UserNameID' >Username :</label>
						<input type='text' size='20' name='".self::$regName."' id='UserNameID' value='".self::GetStripRegName()."' />
						<label for='PasswordID' >Password  :</label>
						<input type='password' size='20' name='" . self::$regPass . "' id='PasswordID' value='' />
						<label for='RepPasswordID' >Repeat password  :</label>
						<input type='password' size='20' name='" . self::$repRegPass . "' id='PasswordID' value='' />
						<input type='submit' name='".self::$regButton."'  value='".self::$regButton."' />
					</fieldset>
				</form>
				</div>";

			$this->rendHTML($content);
		}
	} 