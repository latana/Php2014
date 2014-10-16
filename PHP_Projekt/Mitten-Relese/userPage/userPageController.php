<?php

namespace userPageController;

require_once 'userPage/userPageView.php';
require_once 'model/postModel.php';

class UserPageController {

	private $classUserPageView;

	private $changePassForm;

	private $admin = "Admin";
	
	private $classPostModel;
	
	private $classFrontPageView;

	public function __construct(\frontPageView\FrontPageView $classFrontPageView) {

		$this -> classUserPageView = new \userPageView\UserPageView($classFrontPageView);
		$this -> classUserModel = new \userModel\UserModel();
		$this->classPostModel = new \postModel\PostModel();
		$this->classPostController = new\postController\PostController($classFrontPageView);
		$this->classFrontPageView = $classFrontPageView;
	}

	public function userPage($loginUser) {

		$this -> classPostController->postController($loginUser);

		if ($this -> classUserPageView -> wantToUpdateUser()) {

			$this -> changePassForm = $this -> classUserPageView -> updateUserPassForm();
		}
		if ($this -> classUserPageView -> triedToUpdateUser()) {

			$this -> updatePassWord($loginUser);
		}
		if ($this -> classUserPageView -> tryToChangeProfilePic()) {
			if($this->classPostModel->validatePic($this->classUserPageView->getProfilePic())){
				$profilePicName = $this -> classPostModel -> saveProfilePic($this -> classUserPageView -> getProfilePic(), $loginUser);	
				$this -> classPostModel -> changeProfilePicture($loginUser, $profilePicName);
			}
		}
		$userPostsObject = $this -> classPostModel -> LoadUserPost($loginUser); 
		$userObject = $this -> classPostModel -> LoadUser($loginUser);
		
		$this -> classUserPageView -> showUserPage($this -> changePassForm, $loginUser, $this -> admin, $userPostsObject, $userObject);
	}

	private function updatePassWord($loginUser) {

		if ($this -> classUserPageView -> stripGetNewPass() !== $this -> classUserPageView -> getNewPass()) {
			$this -> classFrontPageView -> setMessage(\frontPageView\FrontPageView::UPDATE_NO_VALID_PASS);
		} else if ($this -> newPassController($this -> classUserPageView -> StripGetNewPass())) {

			$this -> classUserModel -> updateUser($this -> classUserPageView -> stripGetNewPass(), $loginUser);
			$this -> classFrontPageView -> setMessage(\frontPageView\FrontPageView::UPDATE_PASSWORD_SUCCESS);
		}
	}

	private function newPassController($newPass) {

		if ($newPass == null) {
			$this -> classFrontPageView -> setMessage(\frontPageView\FrontPageView::UPDATE_MISSING_PASSWORD);
			return false;
		}
		if ($this -> classUserModel -> checkUpdatePassLength($newPass)) {
			$this -> classFrontPageView -> setMessage(\frontPageView\FrontPageView::UPDATE_PASSWORD_TO_SHORT);
			return false;
		} else {
			return true;
		}
	}
}