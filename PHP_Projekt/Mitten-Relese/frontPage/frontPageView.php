<?php

namespace frontPageView;

require_once 'master/basicView.php';
require_once 'model/DAL/postDAL.php';
require_once 'post/postView.php';

class FrontPageView extends \basicView\BasicView {

	private $allPosts;

	private $allGallery;

	/**
	 * @var string
	 */
	private static $updateUser = "updateUser";

	private static $comment = "comment";

	private static $postButton = "postButton";

	private static $picFile = "picfile";
	
	private $classPostView;
	private $classPostModel;

	public function __construct() {

		$this -> classPostView = new \postView\PostView();
		$this->classPostModel = new\postModel\PostModel();
	}

	public function triedToPost() {
		if (isset($_POST[self::$postButton])) {
			return true;
		}
		return false;

	}

	public static function getComment() {

		if (isset($_POST[self::$comment])) {

			return trim($_POST[self::$comment]);
		}
	}

	public function getPic() {

		if (isset($_POST[self::$postButton])) {

			if ($_FILES[self::$picFile]['size'] > 0) {
				return $_FILES[self::$picFile];
			}
		}
	}

	public function tryGalleryPic() {

		if (isset($_GET[self::$gallery_href])) {
			return true;
		}
		return false;
	}

	public function showFrontPage($loginUser, $admin) {

		$content = "<div class = 'divloggedin'>
				<h2 class = 'loginlogged'> " . $loginUser . " Logged in</h2>" . $this -> navigationButtons($loginUser) ."<div class = 'divloggedinform'>
				<form class = 'postform' method = 'post' enctype='multipart/form-data'>
				<textarea class = 'posttextarea' type='text' name='" . self::$comment . "' rows='10' cols='75'></textarea>
				<input class = 'postbutton' type='submit' name='" . self::$postButton . "'  value='Post' />
				<div class = 'divpic'>
				<label class = 'piclabel' for='file'>Upload Picture:</label>
				<input class = 'picfile' type='file' name='" . self::$picFile . "' id='" . self::$picFile . "'></div>
				</form></div><div class='allPostClass'>" . $this -> classPostView -> showPost($this -> classPostModel -> loadPost(), $this -> classPostModel -> loadUsers(), $loginUser, $admin) . "</div>";

		$this -> rendHTML($content);
	}
}
