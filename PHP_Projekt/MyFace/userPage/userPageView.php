<?php

namespace userPageView;

require_once 'post/postView.php';

class userPageView{

	/**
	 * @var object
	 */
	private $classPostView;

	/**
	 * @var string
	 */
	private static $newPass = "newPass";

	/**
	 * @var string
	 */
	private static $picProfileFile = "picProfileFile";

	/**
	 * @var string
	 */
	private static $updateUser = "updateUser";

	/**
	 * @var string
	 */
	private static $updateButton = "updatebutton";

	/**
	 * @var string
	 */
	private static $changeProfileButton = "picButton";

	/**
	 * @var object
	 */
	private $classFrontPageView;

	public function __construct(\frontPageView\FrontPageView $classFrontPageView) {

		$this -> classPostView = new \postView\PostView();
		$this -> classFrontPageView = $classFrontPageView;
	}

	/**
	 * @return bool
	 * return true if the user wants to update password
	 */
	public function wantToUpdateUser() {

		if (isset($_POST[self::$updateUser])) {
			return true;
		}
		return false;
	}

	/**
	 * @return bool
	 * return true if the user confirmes the change of the password
	 */
	public function triedToUpdateUser() {

		if (isset($_POST[self::$updateButton])) {
			return true;
		}
		return false;
	}

	/**
	 * @return bool
	 * returns true if the user want's to change the profile picture
	 */
	public function tryToChangeProfilePic() {

		if (isset($_POST[self::$changeProfileButton])) {
			return true;
		}
		return false;
	}

	/**
	 * @return string
	 * return the new password without taggs
	 */
	public function stripGetNewPass() {

		if (isset($_POST[self::$updateButton])) {
			return trim(strip_tags($_POST[self::$newPass]));
		}
	}

	/**
	 * @return string
	 * return the new password
	 */
	public function getNewPass() {

		if (isset($_POST[self::$updateButton])) {
			return ($_POST[self::$newPass]);
		}
	}

	/**
	 * @return array
	 * return the picture file if it exist
	 */
	public function getProfilePic() {

		if ($_FILES[self::$picProfileFile]['size'] > 0) {
			return $_FILES[self::$picProfileFile];
		}
	}

	/**
	 * @return string
	 * returns the change password button
	 */
	private function getChangePassButton() {

		return "<div class = 'divupdate'>
					<form class = 'updateform' method = 'post' enctype='multipart/form-data'>
						<input class = 'updateUserButton' type='submit' name='" . self::$updateUser . "' value='Change Password' />
					</form>
				</div>";
	}

	/**
	 * @return string,
	 * returns the form to update the password
	 */
	public function updateUserPassForm() {

		return "<div id = 'gray'></div>
				<div class = 'editpassmenu'>
					<form class = 'cancelform' method='post' enctype='multipart/form-data'>
						<div class='changepassXDiv'>
							<input class = 'thesmalXbutton' type='submit' name='cancel' value='X' />
						</div>
					</form>
					<form class='changepassform' method='post' enctype='multipart/form-data'>
						<label for='passID' >New Password  :</label>
						<input type='password' size='20' name='" . self::$newPass . "'id='" . self::$newPass . "' value='' />
						<div class='editpassdiv'>
							<input class='editPassButton' type='submit' name='" . self::$updateButton . "'  value='Update' />
						</div>
					</form>
				</div> ";
	}

	/**
	 * @return string
	 * return the form for changeing profile picture
	 */
	private function getChangeProfile() {

		return "<div class = 'divpicform'>
					<form class = 'picform' method='post' enctype='multipart/form-data'>
						<label class = 'piclabel'>Choose new profile picture :</label>
						<input class = 'picfile' type='file' name='" . self::$picProfileFile . "' id='" . self::$picProfileFile . "'>
						<input class = 'changeprofileButton' type='submit' name='" . self::$changeProfileButton . "' value='Upload New'>
					</form>
				</div>";
	}

	/**
	 * render out all the posts the user have done
	 * and the userPage
	 */
	public function showUserPage($changePass, $loginUser, \post\PostArray $postArray, \user\UserArray $userArray) {

		$content = "<div class = 'divloggedin'>
						<h2 class = 'loginlogged'> " . $loginUser . " Logged in</h2>
					</div>" .
					$this -> classFrontPageView->NavigationButtons($loginUser) .
					
					"<div class='userPageDiv'>
						".$this -> GetChangePassButton().$changePass . $this -> GetChangeProfile().
					"</div>".
					
	  				"<div class='allPostClass'>".
	  					$this -> classPostView -> ShowPost($postArray,$userArray,$loginUser) .
	  				"</div>";
		
		$this -> classFrontPageView -> rendHTML($content);
	}
}