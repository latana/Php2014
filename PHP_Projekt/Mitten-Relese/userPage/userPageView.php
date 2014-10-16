<?php

namespace userPageView;

require_once 'master/basicView.php';
require_once 'post/postView.php';
require_once 'model/DAL/postDAL.php';

class userPageView{

	private $classPostView;

	/**
	 * @var string
	 */
	public static $newPass = "newPass";

	private static $picProfileFile = "picProfileFile";

	private static $updateUser = "updateUser";

	/**
	 * @var string
	 */
	private static $updateButton = "updatebutton";

	/**
	 * @var string
	 */
	private static $changeProfileButton = "picButton";

	private $classFrontPageView;

	public function __construct(\frontPageView\FrontPageView $classFrontPageView) {

		$this -> classPostModel = new \postModel\PostModel();
		$this -> classPostView = new \postView\PostView();
		$this -> classFrontPageView = $classFrontPageView;
	}

	public function wantToUpdateUser() {

		if (isset($_POST[self::$updateUser])) {

			return true;
		}
		return false;
	}

	/**
	 * @return bool, retunerar true om man försöker ändra lösenord
	 */
	public function triedToUpdateUser() {

		if (isset($_POST[self::$updateButton])) {

			return true;
		}
		return false;
	}

	public function tryToChangeProfilePic() {

		if (isset($_POST[self::$changeProfileButton])) {
			return true;
		}
		return false;
	}

	/**
	 * @return string, retunerar det nya lösenordet
	 */
	public function stripGetNewPass() {

		if (isset($_POST[self::$updateButton])) {

			return trim(strip_tags($_POST[self::$newPass]));
		}
	}

	/**
	 * @return string, retunerar det nya lösenordet
	 */
	public function getNewPass() {

		if (isset($_POST[self::$updateButton])) {

			return ($_POST[self::$newPass]);
		}
	}

	public function getProfilePic() {

		if ($_FILES[self::$picProfileFile]['size'] > 0) {
			return $_FILES[self::$picProfileFile];
		}
	}

	private function getChangePassButton() {

		return "<div class = 'divupdate'>
					<form class = 'updateform' method = 'post' enctype='multipart/form-data'>
					<input class = 'updateUserButton' type='submit' name='" . self::$updateUser . "' value='Change Password' />
					</form></div>";
	}

	/**
	 * @return string, retunerar formuläret
	 * för att uppdatera lösenordet
	 */
	public function updateUserPassForm() {

		return "<div class = 'gray'><div class = 'updateUserClass'> <form method='post' enctype='multipart/form-data'>
							<label for='passID' >Password  :</label>
							<input type='password' size='20' name='" . self::$newPass . "'
							id='" . self::$newPass . "' value='' />
							<input type='submit' name='" . self::$updateButton . "'  value='Update' />
							</form>
							<form class = 'cancelform' method='post' enctype='multipart/form-data'>
							<input class = 'cancelUserButton' type='submit' name='cancel' value='X' />
							</form></div></div> ";
	}

	private function getChangeProfile() {

		return "<div class = 'divpicform'>
					<form class = 'picform' method='post' enctype='multipart/form-data''>
					<label class = 'piclabel' for='file'>Choose new profile picture :</label>
					<input class = 'picfile' type='file' name='" . self::$picProfileFile . "' id='" . self::$picProfileFile . "'>
					<input class = 'changeprofileButton'type='submit' name='" . self::$changeProfileButton . "' value='Upload'>
					</form></div>";
	}

	public function showUserPage($changePass, $loginUser, $admin, \post\PostArray $postArray, \user\UserArray $userArray) {

		$content = "<div class = 'divloggedin'>
				<h2 class = 'loginlogged'> " . $loginUser . " Logged in</h2>" .
				$this -> classFrontPageView->NavigationButtons($loginUser) .
				$this -> GetChangePassButton() .
				$changePass . $this -> GetChangeProfile() .
				$this -> classPostView -> ShowPost($postArray,$userArray,$loginUser, $admin);
		$this -> classFrontPageView -> rendHTML($content);
	}
}