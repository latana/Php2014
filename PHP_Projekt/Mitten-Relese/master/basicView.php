<?php

namespace basicView;

require_once 'master/navigaterView.php';

class BasicView extends \navigaterView\NavigaterView{

	/**
	 * @var int
	 */
	const EMPTY_COMMENT = 0;

	/**
	 * @var int
	 */
	const EMPTY_EDIT_COMMENT = 1;

	/**
	 * @var int
	 */
	const UPDATE_MISSING_PASSWORD = 2;

	/**
	 * @var int
	 */
	const UPDATE_PASSWORD_TO_SHORT = 3;

	/**
	 * @var int
	 */
	const UPDATE_PASSWORD_SUCCESS = 4;

	/**
	 * @var int
	 */
	const UPDATE_NO_VALID_PASS = 5;

	/**
	 * @var int
	 */
	const USER_LOG_OUT = 6;

	/**
	 * @var int
	 */
	const STRIP_TAGS_COMMENT = 7;

	/**
	 * @var int
	 */
	const MISSING_USERNAME = 8;

	/**
	 * @var int
	 */
	const MISSING_PASSWORD = 9;

	/**
	 * @var int
	 */
	const WRONG_USERNAME_PASSWORD = 10;

	/**
	 * @var int
	 */
	const WRONG_COOKIE = 12;

	/**
	 * @var int
	 */
	const WRONG_SESSION = 13;

	/**
	 * @var int
	 */
	const NOT_ALLOWED_USERNAME = 14;

	/**
	 * @var int
	 */
	const USERNAME_TO_SHORT = 15;

	/**
	 * @var int
	 */
	const PASSWORD_TO_SHORT = 16;

	/**
	 * @var int
	 */
	const NO_VALID_USERNAME = 17;

	/**
	 * @var int
	 */
	const PASSWORD_NOT_MATCH = 18;

	/**
	 * @var int
	 */
	const BOTH_TO_SHORT = 19;

	/**
	 * @var int
	 */
	const USERNAME_ALREADY_TAKEN = 20;

	/**
	 * @var int
	 */
	const CREATION_SUCCESS = 21;

	private $allPosts;

	public $message;

	public function showHead() {

		return "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0
			Strict//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd'> 
			<html xmlns='http://www.w3.org/1999/xhtml' lang= 'sv'> 
			<head> 
			<title>MyFace</title>
			<link href='style.css' rel='stylesheet' type='text/css'>
			<meta http-equiv='content-type' content='text/html; charset=utf-8' />   
			</head> <body>
			<div class = 'container'><div class = 'header'>
			<h1 class = 'MyFace'>MyFace</h1></div>";
	}

	public function showFoot() {

		return "<div class = 'footer'>
					<p class = 'ansvarig'> Responsible for the website : Måns Schütz</p>
					</div></div></body></html>";
	}

	public function rendHTML($content) {
		
		echo $this -> showHead() . $this -> message . $content . $this -> showFoot();
	}

	/**
	 * @param $pageMessageType integer
	 * sätter meddelande beroende på vad för variabel som tas emot,
	 * annars så sätts den till null.
	 */

	public function setMessage($messageType = 0) {
		switch($messageType) {
			case self::USERNAME_TO_SHORT :
				$this -> message = "<div class = 'divregfel'><p class = 'regfel'>Username is to short. At least 3 letters</p></div>";
				break;
			case self::PASSWORD_TO_SHORT :
				$this -> message = "<div class = 'divregfel'><p class = 'regfel'>Password is to short. At least 6 letters</p></div>";
				break;
			case self::BOTH_TO_SHORT :
				$this -> message = "<div class = 'divregfel'><p class = 'regfel'>Username must have at 
										least 3 letters and password 6 letters</p></div>";
				break;
			case self::NO_VALID_USERNAME :
				$this -> message = "<div class = 'divregfel'><p class = 'regfel'>No valid letters in username</p></div>";
				break;
			case self::PASSWORD_NOT_MATCH :
				$this -> message = "<div class = 'divregfel'><p class = 'regfel'>Password doesn't match</p></div>";
				break;
			case self::USERNAME_ALREADY_TAKEN :
				$this -> message = "<p>The username is in use. Please try somthing else.</p>";
				break;
			case self::CREATION_SUCCESS :
				$this -> message = "<p>Success. Your welcome to login now.</p>";
				break;
			case self::MISSING_USERNAME :
				$this -> message = "<p class = 'felinloggning'>Username is missing</p>";
				break;
			case self::MISSING_PASSWORD :
				$this -> message = "<p class = 'felinloggning'>Password is missing</p>";
				break;
			case self::WRONG_USERNAME_PASSWORD :
				$this -> message = "<p class = 'felinloggning'>Username or password is wrong</p>";
				break;
			case self:: NOT_ALLOWED_USERNAME :
				$this -> message = "<p class = 'felinloggning'>Please avoid using taggs</p>";
				break;
			case self:: WRONG_SESSION :
				$this -> message = "<p class = 'felinloggning'>Sessionen var korrupt och har tagits bort </p>";
				break;
			case self:: WRONG_COOKIE :
				$this -> message = "<p class = 'felinloggning'>Kakan var korrupt och har tagits bort </p>";
				break;
			case self::EMPTY_COMMENT :
				$this -> message = "<div class = 'divwrongpost'><p class = 'wrongpost'>Please write somthing</p></div>";
				break;
			case self::EMPTY_EDIT_COMMENT :
				$this -> message = "<div class = 'divwrongpost'><p class = 'wrongpost'>You must write somthing in the edit form</p></div>";
				break;
			case self::UPDATE_MISSING_PASSWORD :
				$this -> message = "<div class = 'divwrongpost'><p class = 'wrongpost'>Password is missing</p></div>";
				break;
			case self::UPDATE_PASSWORD_TO_SHORT :
				$this -> message = "<div class = 'divwrongpost'><p class = 'wrongpost'>At least 6 letters in your password</p></div>";
				break;
			case self::UPDATE_PASSWORD_SUCCESS :
				$this -> message = "<div class = 'divwrongpost'><p class = 'wrongpost'>The new password have been saved</p></div>";
				break;
			case self::UPDATE_NO_VALID_PASS :
				$this -> message = "<div class = 'divwrongpost'><p class = 'wrongpost'>Invalid letters in password</p></div>";
				break;
			case self::USER_LOG_OUT :
				$this -> message = "<div class = 'divwrongpost'><p class = 'wrongpost'>You have logged out</p></div>";
				break;
			case self::STRIP_TAGS_COMMENT :
				$this -> message = "<div class = 'divwrongpost'><p class = 'wrongpost'>Please avoid using taggs</p></div>";
				break;
			case self::USER_ALREADY_LOGGEDIN :
			case self::USER_NOT_LOGGEDIN :
			default :
				$this -> message = (string)NULL;
				break;
		}
	}
}