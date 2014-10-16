<?php

namespace memberPageView;

require_once 'model/userModel.php';

class MemberPageView{
	
	private $edit = "edit";
	
	private $delete = "delete";
	
	private static $newPass = 'newpass';
	
	private static $updateButton = 'updatebutton';
	
	private $hiddenEdit = 'hiddenedit';
	
	private $classUserModel;
	
	public function __construct(\frontPageView\FrontPageView $frontPageView){
		
		$this->classFrontPageView = $frontPageView;
		$this->classUserModel = new \userModel\UserModel();
	}
	
	/**
	 * @return bool, retunerar true om man trycker på edit knappen
	 */
	public function wantToEditUser() {
			
		if (isset($_POST[$this -> edit])) {
			return true;
		}
		return false;
	}
	
	/**
	 * @return bool, retunerar true om man trycker på delete knappen
	 */
	public function wantToDeleteUser() {
			
		if (isset($_POST[$this -> delete])) {
			return true;
		}
		return false;
	}
	
	public function getUserID(){
		
		if(isset($_POST[$this->delete])){
			return $_POST[$this->delete];
		}
		if(isset($_POST[$this->edit])){
			return $_POST[$this->edit];
		}
	}
	
	public function adminWantsToEditUser(){
		
		if(isset($_POST[self::$updateButton])){
		
			return true;
		}
		return false;
	}
	
	public function getNewPass(){
		
		if(isset($_POST[self::$updateButton])){
			return $_POST[self::$newPass];
		}
		return false;
	}
	
	public function getNewUserID(){
		if(isset($_POST[$this->hiddenEdit])){
			return $_POST[$this->hiddenEdit];
		}
		return false;
	}
	
	public function showEditFeild($userID){
		
		return $editFeild = "<div class = 'updateUserClass'> <form method='post' enctype='multipart/form-data'>
							<label for='passID' >New password for user ".$userID." :</label>
							<input type='password' size='20' name='" . self::$newPass . "'
							id='" . self::$newPass . "' value='' />
							<input type='hidden' value='" . $userID . "' name='" . $this -> hiddenEdit . "' />
							<input type='submit' name='" . self::$updateButton . "'  value='Update' />
							</form>
							<form class = 'cancelform' method='post' enctype='multipart/form-data'>
							<input class = 'cancelUserButton' type='submit' name='cancel' value='X' />
							</form></div></div> </br>";
	}
	
	public function showMembers($loginUser,\user\UserArray $userArray, $editFeild){
		
		$content = "<h2 class = 'loginlogged'> " . $loginUser . " Logged in</h2>" . $this -> classFrontPageView->NavigationButtons($loginUser);
		
		$content .= $editFeild;
		
		foreach ($userArray->get() as $user) {
			
			$content .= "<div class = 'loadpostclass'><div class = 'divprofilepic'>";
			
			if($loginUser !== $user->getUserName()){
									
				if($user->getProfilePic() == "default.jpg"){
					
					$content .= "<img class = 'postpic' src='upload/".
						$user -> getProfilePic() . "' alt = 'pic''></div>
						<a href='?usergallery&".$user->getUserName()."'>" . $user->getUserName()."</a>";
				}
				else{
					$content .= "<img class = 'postpic' src='upload/" . $user -> getUserName() . "/profile/" .
						$user -> getProfilePic() . "' alt = 'pic''></div>
						<a href='?usergallery&".$user->getUserName()."'>" . $user->getUserName()."</a>";
				}
			
				if($this->classUserModel->isLoggedInAdmin($loginUser)){
						
					$content .= "<div class = 'divedit'><form method='POST'>
					<input type='hidden' value='" . $user->GetUserName() . "' name='".$this->edit."' />
					<input type='submit' value='Edit' /></form></div>";
						
					$content .= "<div class = 'divedit'><form method='POST'>
					<input type='hidden' value='" . $user->GetUserName() . "' name='".$this->delete."' />
					<input type='submit' value='Delete' /></form></div>";
					
				}
				$content .= "</br>";
			}
		}
		$this->classFrontPageView->rendHTML($content);
	}
}
