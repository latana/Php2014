<?php

namespace memberPageController;

require_once 'memberPage/memberPageView.php';
require_once 'model/postModel.php';
require_once 'login/loginModel.php';

class MemberPageController{
	
	private $classMemberPageView;
	
	private $classPostModel;
	
	private $editFeild;
	
	private $classUserModel;
	
	private $userID;
	
	public function __construct(\frontPageView\FrontPageView $frontPageView){
		
		$this->classMemberPageView = new \memberPageView\MemberPageView($frontPageView);
		$this->classPostModel = new \postModel\PostModel();
		$this->classUserModel = new \userModel\UserModel();
	}
	
	public function memberPage($loginUser){
		
		if($this->classMemberPageView->wantToEditUser()){
			
			$this->userID = $this->classMemberPageView->getUserID();
			$this->editFeild = $this->classMemberPageView->showEditFeild($this->classMemberPageView->getUserID());
		}
		if($this->classMemberPageView->adminWantsToEditUser()){
			
			$newPass = $this->classMemberPageView->getNewPass();
			if(!$this->classUserModel->checkUpdatePassLength($newPass)){
				
				$this->classUserModel->updateUser($newPass, $this->classMemberPageView->getNewUserID());
			}
		}
		
		
		if($this->classMemberPageView->wantToDeleteUser()){
			$this->classPostModel->deleteUser($this->classMemberPageView->getUserID());
		}
		
		$this->classMemberPageView->showMembers($loginUser, $this->classPostModel->loadUsers(), $this->editFeild);
	}
}
