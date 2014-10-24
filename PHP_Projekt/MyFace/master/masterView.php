<?php

namespace masterView;

require_once 'navigater/navigaterView.php';

class MasterView extends \navigaterView\NavigaterView{

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
	const STRIP_TAGS_COMMENT = 6;

	/**
	 * @var int
	 */
	const MISSING_USERNAME = 7;

	/**
	 * @var int
	 */
	const MISSING_PASSWORD = 8;

	/**
	 * @var int
	 */
	const WRONG_USERNAME_PASSWORD = 9;

	/**
	 * @var int
	 */
	const WRONG_COOKIE = 10;

	/**
	 * @var int
	 */
	const WRONG_SESSION = 11;

	/**
	 * @var int
	 */
	const NOT_ALLOWED_USERNAME = 12;

	/**
	 * @var int
	 */
	const USERNAME_TO_SHORT = 13;

	/**
	 * @var int
	 */
	const PASSWORD_TO_SHORT = 14;

	/**
	 * @var int
	 */
	const NO_VALID_USERNAME = 15;

	/**
	 * @var int
	 */
	const PASSWORD_NOT_MATCH = 16;

	/**
	 * @var int
	 */
	const BOTH_TO_SHORT = 17;

	/**
	 * @var int
	 */
	const USERNAME_ALREADY_TAKEN = 18;

	/**
	 * @var int
	 */
	const CREATION_SUCCESS = 19;
	
	/**
	 * @var int
	 */
	 const MISSING_PIC = 20;
	 
	 /**
	 * @var int
	 */
	 const MISSING_TITLE = 21;
	 
	 /**
	 * @var int
	 */
	 const STRIP_TAGS_TITLE = 22;
	 
	 /**
	 * @var int
	 */
	 const STRIP_TAGS_DESCRIPTION = 23;
	 
	 /**
	 * @var int
	 */
	 const PIC_VALIDATION = 24;
	 
	 /**
	  * @var int
	  */
	 const PROFILEPIC_SUCCESS = 25;
	 
	 /**
	  * @var int
	  */
	 const PIC_TO_BIG = 26;
	 
	 /**
	  * @var int
	  */
	 const EDIT_GALLERY_SUCCESS = 27;
	 
	 /**
	  * @var int
	  */
	 const EDIT_POST_SUCCESS = 28;
	
	/**
	 * @var int
	 */
	 const DELETE_POST_SUCCESS = 29;
	 
	 /**
	  * @var int
	  */
	 const EDIT_COMMENT_SUCCESS = 30;
	  
	 /**
	  * @var int
	  */
	 const DELETE_COMMENT_SUCCESS = 31;
	   
	 /**
	  * @var int
	  */
	  const DELETE_PIC = 32;
	  
	  /**
	   * @var int
	   */
	   const DELETE_USER = 33;

	/**
	  * @var string
	  */
	public $message;

	/**
	 * @return string
	 * returns html header
	 */
	public function showHead() {

		return "<!DOCTYPE html> 
				<html xmlns='http://www.w3.org/1999/xhtml' lang= 'sv'> 
				<head> 
					<title>MyFace</title>
					<link href='style.css' rel='stylesheet' type='text/css'>
					<meta http-equiv='content-type' content='text/html; charset=utf-8' />   
				</head>
				<body>
					<div class = 'container'><div class = 'header'>
						<h1 class = 'MyFace'>MyFace</h1>
					</div>";
	}

	/**
	 * @return string
	 * returns html footer
	 */
	public function showFoot() {

		return "			<div class = 'footer'>
								<p class = 'ansvarig'> Responsible for the website : Måns Schütz</p>
							</div>
						</div>
					</body>
				</html>";
	}

	/**
	 * @param string
	 * render the header, footer, message and whatever the other view's sends in 
	 */
	public function rendHTML($content) {
		
		echo $this -> showHead() . $this -> message . $content . $this -> showFoot();
	}

	/**
	 * @param $messageType integer
	 * sets the message depending on what number is sent in,
	 * otherwise it will be set to null.
	 */
	public function setMessage($messageType = 0) {
		switch($messageType) {
			case self::USERNAME_TO_SHORT :
				$this -> message = "<div class = 'divwrongmessage'><p class = 'wrongpost'>Username is to short. At least 3 letters</p></div>";
				break;
			case self::PASSWORD_TO_SHORT :
				$this -> message = "<div class = 'divwrongmessage'><p class = 'wrongpost'>Password is to short. At least 6 letters</p></div>";
				break;
			case self::BOTH_TO_SHORT :
				$this -> message = "<div class = 'divwrongmessage'><p class = 'wrongpost'>
											Username must have at least 3 letters and password 6 letters</p></div>";
				break;
			case self::NO_VALID_USERNAME :
				$this -> message = "<div class = 'divwrongmessage'><p class = 'wrongpost'>No valid letters in username</p></div>";
				break;
			case self::PASSWORD_NOT_MATCH :
				$this -> message = "<div class = 'divwrongmessage'><p class = 'wrongpost'>Password doesn't match</p></div>";
				break;
			case self::USERNAME_ALREADY_TAKEN :
				$this -> message = "<div class = 'divwrongmessage'><p class = 'wrongpost'>The username is in use. Please try somthing else.</p></div>";
				break;
			case self::CREATION_SUCCESS :
				$this -> message = "<div class = 'divrightmessage'><p class = 'wrongpost'>Success. Your welcome to login now.</p></div>";
				break;
			case self::MISSING_USERNAME :
				$this -> message = "<div class = 'divwrongmessage'><p class = 'wrongpost'>Username is missing</p></div>";
				break;
			case self::MISSING_PASSWORD :
				$this -> message = "<div class = 'divwrongmessage'><p class = 'wrongpost'>Password is missing</p></div>";
				break;
			case self::WRONG_USERNAME_PASSWORD :
				$this -> message = "<div class = 'divwrongmessage'><p class = 'wrongpost'>Username or password is wrong</p></div>";
				break;
			case self:: NOT_ALLOWED_USERNAME :
				$this -> message = "<div class = 'divwrongmessage'><p class = 'wrongpost'>Please avoid using taggs</p></div>";
				break;
			case self:: WRONG_SESSION :
				$this -> message = "<div class = 'divwrongmessage'><p class = 'wrongpost'>The session was corrupted and has been deleted </p></div>";
				break;
			case self:: WRONG_COOKIE :
				$this -> message = "<div class = 'divwrongmessage'><p class = 'wrongpost'>The cookie was corrupted and has been deleted </p></div>";
				break;
			case self::EMPTY_COMMENT :
				$this -> message = "<div class = 'divwrongmessage'><p class = 'wrongpost'>Please write somthing</p></div>";
				break;
			case self::EMPTY_EDIT_COMMENT :
				$this -> message = "<div class = 'divwrongmessage'><p class = 'wrongpost'>You must write somthing in the edit form</p></div>";
				break;
			case self::UPDATE_MISSING_PASSWORD :
				$this -> message = "<div class = 'divwrongmessage'><p class = 'wrongpost'>Password is missing</p></div>";
				break;
			case self::UPDATE_PASSWORD_TO_SHORT :
				$this -> message = "<div class = 'divwrongmessage'><p class = 'wrongpost'>At least 6 letters in your password</p></div>";
				break;
			case self::UPDATE_PASSWORD_SUCCESS :
				$this -> message = "<div class = 'divrightmessage'><p class = 'wrongpost'>The new password have been saved</p></div>";
				break;
			case self::UPDATE_NO_VALID_PASS :
				$this -> message = "<div class = 'divwrongmessage'><p class = 'wrongpost'>Invalid letters in password</p></div>";
				break;
			case self::STRIP_TAGS_COMMENT :
				$this -> message = "<div class = 'divwrongmessage'><p class = 'wrongpost'>Please avoid using taggs</p></div>";
				break;
			case self::MISSING_PIC :
				$this -> message = "<div class = 'divwrongmessage'><p class = 'wrongpost'>Picture is missing</p></div>";
				break;
			case self::MISSING_TITLE :
				$this -> message = "<div class = 'divwrongmessage'><p class = 'wrongpost'>A title is missing</p></div>";
				break;
			case self::STRIP_TAGS_TITLE :
				$this -> message = "<div class = 'divwrongmessage'><p class = 'wrongpost'>Please avoid using taggs in the title input</p></div>";
				break;
			case self::STRIP_TAGS_DESCRIPTION :
				$this -> message = "<div class = 'divwrongmessage'><p class = 'wrongpost'>Please avoid using taggs in the description input</p></div>";
				break;
			case self::PIC_VALIDATION :
				$this -> message = "<div class = 'divwrongmessage'><p class = 'wrongpost'>Invalid file! 
												Please make sure the file is of type PNG, JPG or JPEG and that the img format is 
																										the same as the img type.</p></div>";
				break;
			case self::PROFILEPIC_SUCCESS :
				$this -> message = "<div class = 'divrightmessage'><p class = 'wrongpost'>Your Profilepicture has been changed</p></div>";
				break;
			case self::PIC_TO_BIG :
				$this -> message = "<div class = 'divwrongmessage'><p class = 'wrongpost'>The picture is to big. No more than 3 mb!</p></div>";
				break;
			case self::EDIT_GALLERY_SUCCESS :
				$this -> message = "<div class = 'divrightmessage'><p class = 'wrongpost'>Your picture's title and description has been updated</p></div>";
				break;
			case self::EDIT_POST_SUCCESS :
				$this -> message = "<div class = 'divrightmessage'><p class = 'wrongpost'>Your post has been updated</p></div>";
				break;
			case self::DELETE_POST_SUCCESS :
				$this -> message = "<div class = 'divrightmessage'><p class = 'wrongpost'>Your post has been deleted</p></div>";
				break;
			case self::EDIT_COMMENT_SUCCESS :
				$this -> message = "<div class = 'divrightmessage'><p class = 'wrongpost'>Your comment has been updated</p></div>";
				break;
			case self::DELETE_COMMENT_SUCCESS :
				$this -> message = "<div class = 'divrightmessage'><p class = 'wrongpost'>Your comment has been deleted</p></div>";
				break;
			case self::DELETE_PIC :
				$this -> message = "<div class = 'divrightmessage'><p class = 'wrongpost'>Your picture has been deleted</p></div>";
				break;
			case self::DELETE_USER :
				$this -> message = "<div class = 'divrightmessage'><p class = 'wrongpost'>The member has been deleted</p></div>";
				break;
			case self::USER_ALREADY_LOGGEDIN : 
			case self::USER_NOT_LOGGEDIN :
			default :
				$this -> message = (string)NULL;
				break;
		}
	}
}