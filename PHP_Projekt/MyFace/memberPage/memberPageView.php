<?php

namespace memberPageView;

require_once 'settings.php';

class MemberPageView{
	
	/**
	 * @var string
	 */
	private $edit = "edit";
	
	/**
	 * @var string
	 */
	private $delete = "delete";
	
	/**
	 * @var string
	 */
	private static $newPass = 'newpass';
	
	/**
	 * @var string
	 */
	private static $updateButton = 'updatebutton';
	
	/**
	 * @var string
	 */
	private $hiddenEdit = 'hiddenedit';
	
	/**
	 * @var string
	 */
	private static $admin;
	
	/**
	 * @var string
	 */
	private static $areYouSure = "areYouSure";
	
	/**
	 * @var string
	 */
	private static $defaultPic;
	
	/**
	 * @var object
	 */
	private $classFrontPageView;
	
	public function __construct(\frontPageView\FrontPageView $frontPageView){
		
		$this->classFrontPageView = $frontPageView;

		self::$admin = \settings\Settings::$admin;
		self::$defaultPic = \settings\Settings::$defaultPic;
	}
	
	/**
	 * @return bool
	 * return true if the user pressed the edit button
	 */
	public function wantToEditUser() {
			
		if (isset($_POST[$this -> edit])) {
			return true;
		}
		return false;
	}
	
	/**
	 * @return bool
	 * return true if the user pressed the delete button
	 */
	public function wantToDeleteUser() {
			
		if (isset($_POST[$this -> delete])) {
			return true;
		}
		return false;
	}
	
	/**
	 * @return bool
	 * returns the id of the activ user
	 */
	public function getUserID(){
		
		if(isset($_POST[$this->delete])){
			return $_POST[$this->delete];
		}
		if(isset($_POST[$this->edit])){
			return $_POST[$this->edit];
		}
	}
	
	/**
	 * @return bool
	 * return true if admin wants to edit the member
	 */
	public function adminWantsToEditUser(){
		
		if(isset($_POST[self::$updateButton])){
			return true;
		}
		return false;
	}
	
	/**
	 * @return string
	 * returns the new password
	 */
	public function getNewPass(){
		
		if(isset($_POST[self::$updateButton])){
			return $_POST[self::$newPass];
		}
	}
	
	/**
	 * @return string
	 * returns the new password stripped
	 */
	public function getStripNewPass(){
		
		if(isset($_POST[self::$updateButton])){
			return trim(strip_tags($_POST[self::$newPass]));
		}
	}
	
	/**
	 * @return string
	 * returns the id of the activ member
	 */
	public function getNewUserID(){
		if(isset($_POST[$this->hiddenEdit])){
			return $_POST[$this->hiddenEdit];
		}
	}
	
	/**
	 * @return bool
	 * returns true if the user tries to delete one member
	 */
	public function triedToDeleteUser(){
		
		if(isset($_POST[self::$areYouSure])){
			return true;
		}
		return false;
	}
	
	/**
	 * @return string
	 * returns the id of the activ user from the edit menu
	 */
	public function getDeleteUserId(){
		
		if(isset($_POST[self::$areYouSure])){
			return $_POST[self::$areYouSure];
		}
	}
	
	/**
	 * @param string
	 * @return string
	 * returns the delete member menu
	 */
	public function areYouSureFeild($memberName){
		
		return $areYouSureField ="
		
			<div id='gray'></div>
				<div class = 'areYouSure'>
					<p class='areYouSureP'>
						If you delete user ".$memberName.". Everything releated to ".$memberName."
										will be deleted.Do you still want to delete user ".$memberName."?
					</p>
					<div class='deleteuserButtonDiv'>
						<form method='post' enctype='multipart/form-data'>
							<input type='hidden' name='" . self::$areYouSure . "'  value='".$memberName."' />
							<input class = 'thesmalXbutton' type='submit' name='deleteUser'  value='Delete' />
						</form>
						<div class='cancleDiv'>
							<form class = 'cancelform' method='post' enctype='multipart/form-data'>
								<input class = 'thesmalcanclebutton' type='submit' name='cancel' value='Cancel' />
							</form>
						</div>
					</div>
				</div>";
	}
	
	/**
	 * @param memberName string
	 * @return string
	 * returns the edit member password menu
	 */
	public function showEditFeild($memberName){
		
		return $editFeild = "<div id='gray'></div>
							<div class = 'editpassmenu'>
								<form class = 'cancelform' method='post' enctype='multipart/form-data'>
									<input class = 'thesmalXbutton' type='submit' name='cancel' value='X' />
								</form>
								<form class='changepassform' method='post' enctype='multipart/form-data'>
									<label for='passID' >New password for user ".$memberName."</label>
									<input type='password' size='20' name='" . self::$newPass . "'id='" . self::$newPass . "' value='' />
									<input type='hidden' value='" . $memberName . "' name='" . $this -> hiddenEdit . "' />
									<div class='editpassdiv'>
										<input class='editPassButton' type='submit' name='" . self::$updateButton . "'  value='Update' />
									</div>
								</form>
							</div>";
	}
	
	/**
	 * @param editFeild string
	 * @param areYouSureField string
	 * render out the user exeped the one who is logged in
	 */
	public function showMembers($loginUser,\user\UserArray $userArray, $editFeild, $areYouSureField){
		
		$content = "<div class='divloggedin'>
						<h2 class = 'loginlogged'> " . $loginUser . " Logged in</h2>
					</div>"
						. $this -> classFrontPageView->NavigationButtons($loginUser);
		
		$content .= $editFeild . $areYouSureField;
		
		$content .= "<div class = 'loadUsers'>";
		
		foreach ($userArray->get() as $user) {
			
			if($loginUser !== $user->getUserName()){
																
				$content .= "<div class ='oneUser'>
								<div class='loadUsePic'>
									<a class='AuserLink' href='?usergallery=".$user->getUserName()."'>
								 		<img class = 'postpic' src='upload/" . $user -> getUserName() . "/profile/" .
								 												$user -> getProfilePic() . "' alt = 'pic'>
								 	</a>
								</div>
								<div class='userLink'>
									<a class='AuserLink' href='?usergallery=".$user->getUserName()."'>" . $user->getUserName()."</a>
								</div>";
				
				if($loginUser == self::$admin){
							
					$content .= "<div class = 'divEditUser'>
									<form method='POST'>
										<input type='hidden' value='" . $user->GetUserName() . "' name='".$this->edit."' />
										<input class='editMemberButton' type='submit' value='Edit' />
									</form>
								</div>";
							
					$content .= "<div class = 'divDeleteUser'>
									<form method='POST'>
										<input type='hidden' value='" . $user->GetUserName() . "' name='".$this->delete."' />
										<input class='deleteMemberButton' type='submit' value='Delete' />
									</form>
								</div>";	
				}
				$content .= "</div>";
			}
		}
		$content .= "</div>";
		
		$this->classFrontPageView->rendHTML($content);
	}
}