<?php

namespace userPageController;

require_once 'userPage/userPageView.php';
require_once 'model/postModel.php';
require_once 'model/userModel.php';
require_once 'post/postController.php';

class UserPageController {

	/**
	 * @var object
	 */
	private $classUserPageView;

	/**
	 * @var string
	 */
	private $changePassForm;

	/**
	 * @var object
	 */
	private $classPostModel;

	/**
	 * @var object
	 */
	private $classFrontPageView;

	/**
	 * @var object
	 */
	private $classUserModel;
	
	public function __construct(\frontPageView\FrontPageView $classFrontPageView, $loginUser) {

		$this -> classUserPageView = new \userPageView\UserPageView($classFrontPageView);
		$this -> classUserModel = new \userModel\UserModel();
		$this -> classPostModel = new \postModel\PostModel();
		$this -> classPostController = new\postController\PostController($classFrontPageView);
		$this -> classFrontPageView = $classFrontPageView;
		
		$this->userPage($loginUser);
	}

	/**
	 * @param loginUser string
	 * Check if user want's to change password, profile picture,
	 * edit or delete a post, and show's userPage
	 */
	public function userPage($loginUser) {

		$this -> classPostController->postController($loginUser);

		if ($this -> classUserPageView -> wantToUpdateUser()) {

			$this -> changePassForm = $this -> classUserPageView -> updateUserPassForm();
		}
		if ($this -> classUserPageView -> triedToUpdateUser()) {

			$this -> updatePassWord($loginUser);
		}
		if ($this -> classUserPageView -> tryToChangeProfilePic()) {
			
			if($this->classUserPageView->getProfilePic() == null){
				$this->classFrontPageView->setMessage(\frontPageView\FrontPageView::MISSING_PIC);
			}
			else{
				if($this->classUserModel->validatePic($this->classUserPageView->getProfilePic())){
					
					if($this -> classUserModel -> checkPicSize($this->classUserPageView->getProfilePic())){
						
						$profilePicName = $this -> classUserModel -> saveProfilePic($this -> classUserPageView -> getProfilePic(), $loginUser);	
						$this -> classUserModel -> changeProfilePicture($loginUser, $profilePicName);
						$this->classFrontPageView->setMessage(\frontPageView\FrontPageView::PROFILEPIC_SUCCESS);
					}
					else{
						$this->classFrontPageView->setMessage(\frontPageView\FrontPageView::PIC_TO_BIG);
					}
				}
				else{
					$this->classFrontPageView->setMessage(\frontPageView\FrontPageView::PIC_VALIDATION);
				}
			}
		}
		$userPostsObject = $this -> classPostModel -> LoadUserPost($loginUser); 
		$userObject = $this -> classUserModel -> LoadUser($loginUser);
		
		$this -> classUserPageView -> showUserPage($this -> changePassForm, $loginUser, $userPostsObject, $userObject);
	}

	/**
	 * @param loginUser string
	 * conpare the two passwords and saves if it is valid
	 */
	private function updatePassWord($loginUser) {

		if ($this -> classUserPageView -> stripGetNewPass() !== $this -> classUserPageView -> getNewPass()) {
			$this -> classFrontPageView -> setMessage(\frontPageView\FrontPageView::UPDATE_NO_VALID_PASS);
		}
		else if ($this -> newPassController($this -> classUserPageView -> StripGetNewPass())) {
			$this -> classUserModel -> updateUser($this -> classUserPageView -> stripGetNewPass(), $loginUser);
			$this -> classFrontPageView -> setMessage(\frontPageView\FrontPageView::UPDATE_PASSWORD_SUCCESS);
		}
	}

	/**
	 * @param newPass string
	 * @return bool
	 * validates the new password
	 */
	private function newPassController($newPass) {

		if ($newPass == null) {
			$this -> classFrontPageView -> setMessage(\frontPageView\FrontPageView::UPDATE_MISSING_PASSWORD);
			return false;
		}
		if ($this -> classUserModel -> checkUpdatePassLength($newPass)) {
			$this -> classFrontPageView -> setMessage(\frontPageView\FrontPageView::UPDATE_PASSWORD_TO_SHORT);
			return false;
		}
		else {
			return true;
		}
	}
}