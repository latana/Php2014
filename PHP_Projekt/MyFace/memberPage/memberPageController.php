<?php

namespace memberPageController;

require_once 'memberPage/memberPageView.php';
require_once 'model/postModel.php';
require_once 'model/userModel.php';

class MemberPageController{
	
	/**
	 * @var object
	 */
	private $classMemberPageView;

	/**
	 * @var object
	 */	
	private $classPostModel;

	/**
	 * @var string
	 */
	private $editFeild;

	/**
	 * @var object
	 */	
	private $classUserModel;
	
	/**
	 * @var string
	 */
	private $userID;
	
	/**
	 * @var string
	 */
	private $areYouSureFeild;
	
	public function __construct(\frontPageView\FrontPageView $frontPageView, $loginUser){
		
		$this->classFrontPageView = $frontPageView;
		$this->classMemberPageView = new \memberPageView\MemberPageView($frontPageView);
		$this->classPostModel = new \postModel\PostModel();
		$this->classUserModel = new \userModel\UserModel();
		$this->memberPage($loginUser);
	}
	
	/**
	 * @param loginUser string
	 * checks what the user tries to do and showes the memberPage
	 */
	public function memberPage($loginUser){
		
		if($this->classMemberPageView->wantToEditUser()){
			
			$this->userID = $this->classMemberPageView->getUserID();
			$this->editFeild = $this->classMemberPageView->showEditFeild($this->classMemberPageView->getUserID());
		}
		if($this->classMemberPageView->adminWantsToEditUser()){
			
			$this->changeMemberPassword();
		}	
		if($this->classMemberPageView->wantToDeleteUser()){
			$this->areYouSureFeild = $this->classMemberPageView->areYouSureFeild($this->classMemberPageView->getUserID());
		}
		if($this->classMemberPageView->triedToDeleteUser()){
			$this->classPostModel->deleteUser($this->classMemberPageView->getDeleteUserId());
			$this->classFrontPageView->setMessage(\frontPageView\FrontPageView::DELETE_USER);
			
		}
		$this->classMemberPageView->showMembers($loginUser, $this->classUserModel->loadUsers(), $this->editFeild, $this->areYouSureFeild);
	}
	
	/**
	 * handles the new password
	 */
	private function changeMemberPassword(){
		
		$newPass = $this->classMemberPageView->getNewPass();
			
		if($this->validateNewPass($newPass)){
				
			$this->classUserModel->updateUser($newPass, $this->classMemberPageView->getNewUserID());
			$this->classFrontPageView->setMessage(\frontPageView\FrontPageView::UPDATE_PASSWORD_SUCCESS);
		}
	}
	
	/**
	 * @param newPass string
	 * @return bool
	 * validates the new password and returns true if the password is valid
	 */
	private function validatenewPass($newPass){
	
		if($newPass == null){
			$this->classFrontPageView->setMessage(\frontPageView\FrontPageView::UPDATE_MISSING_PASSWORD);
			return false;
		}
		if($this->classMemberPageView->getStripNewPass() !== $newPass){
			$this->classFrontPageView->setMessage(\frontPageView\FrontPageView::UPDATE_NO_VALID_PASS);
			return false;
		}
		if($this->classUserModel->checkUpdatePassLength($newPass)){
			$this->classFrontPageView->setMessage(\frontPageView\FrontPageView::UPDATE_PASSWORD_TO_SHORT);
			return false;
		}
		return true;
	}
}