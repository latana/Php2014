<?php

namespace frontPageView;

require_once 'master/masterView.php';
require_once 'model/DAL/postDAL.php';
require_once 'post/postView.php';
require_once 'settings.php';

class FrontPageView extends \masterView\MasterView {

	/**
	 * @var string
	 */
	private static $comment = "comment";

	/**
	 * @var string
	 */
	private static $postButton = "postButton";

	/**
	 * @var string
	 */
	private static $picFile = "picfile";
	
	/**
	 * @var object
	 */
	private $classPostView;
		
	/**
	 * @var string
	 */
	private static $frontPage;
	
	/**
	 * @var string
	 */
	private static $PHP_SELF;
	
	/**
	 * @var string
	 */
	private static $location;

	public function __construct() {

		$this -> classPostView = new \postView\PostView();
		
		self::$frontPage = \settings\Settings::$frontPage;
		self::$PHP_SELF = \settings\Settings::$PHP_SELF;
		self::$location = \settings\Settings::$location;
	}
	
	/**
	 * reload page
	 */
	public function reloadPage(){
		header(self::$location.$_SERVER[self::$PHP_SELF]."?".self::$frontPage);
	}
	
	/**
	 * @return bool;
	 * return true if user want's to post
	 */
	public function triedToPost() {
			
		if (isset($_POST[self::$postButton])) {
			return true;
		}
		return false;
	}

	/**
	 * @return string
	 * return the user comment input
	 */
	public static function getComment() {

		if (isset($_POST[self::$comment])) {
			return trim($_POST[self::$comment]);
		}
	}

	/**
	 * @return array
	 * return the user's uploaded file
	 */
	public function getPic() {

		if (isset($_POST[self::$postButton])) {

			if ($_FILES[self::$picFile]['size'] > 0) {
				return $_FILES[self::$picFile];
			}
		}
	}

	/**
	 * @param loginUser string
	 * Send objects into postView who handles the post correct
	 * and then render it in masterView;
	 */
	public function showFrontPage(\post\PostArray $postArray, \user\UserArray $userArray, $loginUser) {

		$content = "<div class = 'divloggedin'>
						<h2 class = 'loginlogged'> " . $loginUser . " Logged in</h2>
					</div>"
					. $this -> navigationButtons($loginUser) .
					"<div class = 'divloggedinform'>
						<form class = 'postform' method = 'post' enctype='multipart/form-data'>
							<textarea class = 'posttextarea' name='" . self::$comment . "' rows='7' cols='28'></textarea>
							<div class = 'divpic'>
								<label class = 'piclabel'>Upload Picture:</label>
								<input class = 'picfile' type='file' name='" . self::$picFile . "' id='" . self::$picFile . "'>
							</div>
							<input class = 'postbutton' type='submit' name='" . self::$postButton . "'  value='Post' />
						</form>
					</div>
					<div class='allPostClass'>"
						. $this -> classPostView -> showPost($postArray, $userArray, $loginUser) .
					"</div>";

		$this -> rendHTML($content);
	}
}