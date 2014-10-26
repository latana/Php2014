<?php

namespace galleryPageView;

require_once 'post/postView.php';

class GalleryPageView{

	/**
	 * @var string 
	 */
	private static $galleryFile = "galleryFile";

	/**
	 * @var string 
	 */
	private static $galleryButton = "gallerybutton";

	/**
	 * @var string 
	 */
	private static $gallery_href = "gallery";

	/**
	 * @var string 
	 */
	private static $galleryName = "galleryName";

	/**
	 * @var string 
	 */
	private static $description = "description";
	
	/**
	 * @var string 
	 */
	private static $editTitle = "editTitle";

	/**
	 * @var string 
	 */
	private static $editDescription = "editDescription";

	/**
	 * @var string 
	 */
	private $allGallery;

	/**
	 * @var string 
	 */
	private $delete = "DeleteGallery";
	
	/**
	 * @var string 
	 */
	private $deleteTitle = "deleteTitle";
	
	/**
	 * @var string 
	 */
	private $edit = "editGallery";
	
	/**
	 * @var string 
	 */
	private $picComment = "picComment";
	
	/**
	 * @var string 
	 */
	private $commentPicButton = "commentPicButton";
	
	/**
	 * @var string 
	 */
	private static $editGalleryButton = "editCommentPicButton";
	
	/**
	 * @var object 
	 */	
	private $classPostView;
	
	 
	 /**
	 * @var object 
	 */	
	private $classFrontPageView;
	
	/**
	 * @var object 
	 */	
	private static $userGallery;

	/**
	 * @var string 
	 */		
	private static $uploadPath;


	/**
	 * @var string 
	 */	
	private static $galleryPath;


	/**
	 * @var string 
	 */	
	private static $thumbnail;


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
	private static $location;


	/**
	 * @var string 
	 */	
	private static $PHP_SELF;


	/**
	 * @var string 
	 */	
	private static $REQUEST_URI;

	public function __construct(\frontPageView\FrontPageView $classFrontPageView) {

		$this->classPostView = new \postView\PostView();
		$this->classFrontPageView = $classFrontPageView;
		
		self::$userGallery = \settings\Settings::$userGallery;
		self::$uploadPath = \settings\Settings::$uploadPath;
		self::$galleryPath = \settings\Settings::$galleryPath;
		self:: $thumbnail = \settings\Settings::$thumbnail;
		self::$admin = \settings\Settings::$admin;
		self::$PHP_SELF = \settings\Settings::$PHP_SELF;
		self::$location = \settings\Settings::$location;
		self::$REQUEST_URI = \settings\Settings::$REQUEST_URI;
		
	}
	
	/**
	 * reload page
	 */
	public function reloadPage(){
		
		$urlName = explode("=",$_SERVER[self::$REQUEST_URI]);
		
		header(self::$location.$_SERVER[self::$PHP_SELF]."?".self::$userGallery."=".$urlName[1]);
	}
	
	/**
	 * reload page with selected picture
	 */
	public function reloadSelectedPic($id){
		
		$getPartOfurlName = explode("=",$_SERVER[self::$REQUEST_URI]);
		
		$getCleanUrlName = explode("&", $getPartOfurlName[1]);
		
		header(self::$location.$_SERVER[self::$PHP_SELF]."?".self::$userGallery."="
									.$getCleanUrlName[0]."&".self::$galleryPath."=".$id);
	}
	
	/**
	 * @return string
	 * get the name from the url
	 */
	public function getMembersGallery(){
		
		$getPartOfurlName = explode("=",$_SERVER[self::$REQUEST_URI]);
		
		if(count($getPartOfurlName) < 2){
			return false;
		}
		$getCleanUrlName = explode("&", $getPartOfurlName[1]);
		
		return $getCleanUrlName[0];	
	}

	/**
	 * @return bool
	 * return true if the user clicked on a picture
	 */
	public function userWantToLookAtPic() {

		if (isset($_GET[self::$gallery_href])) {
			return true;
		}
		return false;
	}

	/**
	 * @return string
	 * return the pictures id
	 */
	public function getGalleryID() {

		if (isset($_GET[self::$gallery_href])) {
			return $_GET[self::$gallery_href];
		}
	}

	/**
	 * @return bool
	 * return true if the user tries to upload a picture
	 */
	public static function tryToUploadGallery() {

		if (isset($_POST[self::$galleryButton])) {
			return true;
		}
		return false;
	}

	/**
	 * @return string
	 * return the pictures title
	 */
	public function getGalleryName() {

		if (isset($_POST[self::$galleryButton])) {
			return trim($_POST[self::$galleryName]);
		}
	}

	/**
	 * @return string
	 * return the pictures description
	 */
	public function getDescription() {

		if (isset($_POST[self::$galleryButton])) {
			return $_POST[self::$description];
		}
	}

	/**
	 * @return array|false
	 * return the picture. if the pictures size is 0
	 * it will return false;
	 */
	public function getGalleryPic() {

		if ($_FILES[self::$galleryFile]['size'] > 0) {
			return $_FILES[self::$galleryFile];
		}
		return false;
	}

	/**
	 * @return bool
	 * return true if the user want's to delete a picture
	 */
	public function userWantToDeletePic() {

		if (isset($_POST[$this -> delete])) {
			return true;
		}
		return false;
	}
	
	/**
	 * @return bool
	 * return true if the user want's to edit a picture
	 */
	public function userWantToEditPic() {

		if (isset($_POST[$this -> edit])) {
			return true;
		}
		return false;
	}
	
	/**
	 * @return string
	 * return the id of the selected picture
	 */
	public function getPicID() {

		if (isset($_POST[$this -> delete])) {
			return $_POST[$this -> delete];
		}
		if(isset($_POST[$this->edit])){
			return $_POST[$this->edit];
		}
		return false;
	}
	
	/**
	 * @return bool
	 * return true if the user want to comment a picture
	 */
	public function userWantToCommentPic(){
		
		if(isset($_POST[$this->commentPicButton])){
			return true;
		}
		return false;
	}
	
	/**
	 * @return string
	 * return the posted comment
	 */
	public function getPicComment(){
		
		if(isset($_POST[$this->commentPicButton])){
			return trim($_POST[$this->picComment]);
		}
	}
	
	/**
	 * @return bool
	 * return true if the user tries to edit the picture
	 */
	public function getEditGalleryButton(){
		
		if(isset($_POST[self::$editGalleryButton])){
			return true;
		}
		return false;
	}
	
	/**
	 * @return string
	 * return the id of the picture the user want's to change
	 */
	public function getEditGalleryButtonID(){
		
		if(isset($_POST[self::$editGalleryButton])){
			return $_POST[self::$editGalleryButton];
		}
	}
	
	/**
	 * @return string
	 * return the new title
	 */
	public function getNewTitle(){
		
		if(isset($_POST[self::$editTitle])){
			return trim($_POST[self::$editTitle]);
		}
	}
	
	/**
	 * @return string
	 * return the new description
	 */
	public function getNewDescription(){
	
		if(isset($_POST[self::$editDescription])){
			return trim($_POST[self::$editDescription]);
		}
		return false;	
	}
	
	/**
	 * @return bool
	 * return true if the user is sure they want to delete the picture
	 */
	public function triedToDeletePic(){
		
		if(isset($_POST[self::$areYouSure])){
			return true;
		}
		return false;
	}
	
	/**
	 * @return string
	 * returns the id of the picture the user want's to delete 
	 */
	public function getDeleteUserId(){
		
		if(isset($_POST[self::$areYouSure])){
			return $_POST[self::$areYouSure];
		}
	}
	
	/**
	 * @return string
	 * return the title of the picture the user want's to delete
	 */
	public function getDeleteTitle(){
		
		if(isset($_POST[$this->deleteTitle])){
			return $_POST[$this->deleteTitle];
		}
		return false;
	}
	
	/**
	 * @return string
	 * returns the message if the picture can't be found
	 */
	public function showCanNotFindPic(){
		
		$selectedPic = "<h3 class='ErrorH3'>The selected img could not be found!</h3>";
		
		return $selectedPic;
	}
	
	/**
	 * @param loginUser string
	 * @param member string
	 * send's out an errormessage that the user can't be found
	 */
	public function showGalleryNotFound($loginUser, $member){
			
		$content = "<div class = 'divloggedin'>
						<h2 class = 'loginlogged'> " . $loginUser . " Logged in</h2>
					</div>" .
					$this -> classFrontPageView->navigationButtons($loginUser);
					
		if($loginUser == $member){
			$content .= $this -> getGalleryButtons();
			$this->classFrontPageView->rendHTML($content);
		}
		else{
			$content .="<h3 class='ErrorH3'>The selected user could not be found!</h3>";
			$this->classFrontPageView->rendHTML($content);
		}
	}
	
	/**
	 * @param id string
	 * @param title string
	 * setts the warning message to $areYouSureField 
	 */
	public function areYouSureFeild($id, $title){

		return $areYouSureField = "<div id ='gray'></div>
									<div class = 'areYouSure'>
										<p class='areYouSureP'>Are you sure you want to delete picture ".$title."?</p>
										<div class='deleteuserButtonDiv'>
											<form method='post' enctype='multipart/form-data'>
												<input type='hidden' name='" . self::$areYouSure . "'  value='".$id."' />
												<input class = 'thesmalXbutton' type='submit' name='deletePic'  value='Delete' />
											</form>
										</div>
										<div class='cancleDiv'>
											<form class = 'cancelform' method='post' enctype='multipart/form-data'>
												<input class = 'thesmalcanclebutton' type='submit' name='cancel' value='Cancel' />
											</form>
										</div>
									</div>";
	}
	
	/**
	 * @param galleryID int
	 * @param title string
	 * @return string
	 * creates the edit and delete buttons for the picture
	 */
	public function doDeleteAndEditGalleryButton($galleryID, $title) {

		$galleryButton = "<div class = 'divedit'>
							<form method='POST'>
								<input type='hidden' value='" . $galleryID . "' name='" . $this -> edit . "' />
								<input class='editButton' type='submit' value='Edit' />
							</form>
						 </div>";	

		$galleryButton .= "<div class = 'divdelete'>
							<form method='POST'>
								<input type='hidden' value='" . $galleryID . "' name='" . $this -> delete . "' />
								<input type='hidden' value='" . $title . "' name='" . $this -> deleteTitle . "' />
								<input class='deleteButton' type='submit' value='Delete' />
							</form>
						  </div>";
			
		return $galleryButton;
	}

	/**
	 * @param loginUser string
	 * @return string
	 * returns the selected picture with it's comments
	 */
	public function showSelectedPic(\gallery\GalleryArray $galleryArray, \comment\CommentArray $commentArray, \user\UserArray $userArray, $loginUser) {
		
		foreach ($galleryArray->get() as $gallery) {
			
			$selectedPic = "
			<div id ='gray'></div>
			<div class='selectedpicdiv'>
				<form method='POST'>
					<div class = 'Xbutton'>
						<a class='theXbutton' href = '?".self::$userGallery."=".$gallery->getgalleryUserName()."' 
																title = 'Xbutton' name = 'Xbutton'>X</a>
					</div>
				</form>
					<div class='galleryPicDiv'>
						<img class = 'gallerypicSelected' src='".self::$uploadPath."/" . $gallery -> getgalleryUserName().
												"/".self::$galleryPath."/" . $gallery -> getgalleryURL() . "' alt = 'pic'>
					</div>
					<div class = 'galleryDescription'>
					<p>".$gallery->getgalleryPicComment()."</p>
					</div>
				<div class ='postFormDiv'>
					<form method='POST'>
						<textarea class = 'posttextarea' name='".$this->picComment."' rows='3' cols='25'></textarea>
						<input type='hidden' value='" . $gallery->getgalleryID() . "' name='" . $this->commentPicButton . "' />
						<input class = 'commentPicButton' type='submit' value='Comment'>
					</form>
				</div><div class ='allCommentsDiv'>";
					
			foreach ($commentArray->get() as $comment) {
				if($gallery->getgalleryID() == $comment->getGalleryID()){
					$selectedPic .= $this->classPostView->showComment($commentArray, $userArray, $loginUser);	
					break;
				}
			}
		}
		$selectedPic .= "</div></div>";
		return $selectedPic;
	}

	/**
	 * @param loginUser string
	 * @param member string
	 * @param editForm string
	 * @param areYouSureField string
	 * @param selectedPic string
	 * render out the selected users gallery
	 */
	public function showGalleryPage(\gallery\GalleryArray $galleryArray, $loginUser, $member, $editForm, $areYouSureField, $selectedPic) {

		$content = "<div class = 'divloggedin'>
						<h2 class = 'loginlogged'> " . $loginUser . " Logged in</h2>
					</div>";
				
		$content .=	$this -> classFrontPageView->navigationButtons($loginUser) . $areYouSureField;
				
				if($loginUser == $member){
					$content .= $this -> getGalleryButtons();
				}
				$content .= $selectedPic . $editForm . $this -> showGalleryPost($galleryArray, $member, $loginUser);

		$this -> classFrontPageView->rendHTML($content);
	}
	
	/**
	 * @return string
	 * creates the edit menu for the picture
	 */
	public function getEditMenu(\gallery\GalleryArray $galleryArray){
				
		$editForm = '';	
		
		foreach ($galleryArray->get() as $gallery) {
		
		$editForm .= 
		
		"<div id='gray'></div>
		<div class = 'editGallerymenu'>
			<form enctype='multipart/form-data' method='post'>
				<div class='divthesmalXbutton'>
					<input class='thesmalXbutton' type='submit' value='X'>
				</div>
			</form>
			<form class = 'EditgalleryForm' method='post' enctype='multipart/form-data'>
				<div class='editTitleDiv'>
					<label class ='editTitleLable'>New Title :</label>
					<input class='editTitleInput' type='text' size='20' maxlength='34' name='".self::$editTitle."'id='".self::$editTitle."
																				'value='".$gallery->getgalleryPicName()."'/>
				</div>
				<div class='editDescriptionDiv'>
					<label class='editDescriptionLable'>New Description :</label>
					<textarea class='posttextarea'type='text'name='".self::$editDescription."'rows='3' cols='25'>"
																	.$gallery->getgalleryPicComment()."</textarea>
					</div>
				<input type='hidden'class='editgalleryButton'type='submit' name='".self::$editGalleryButton."'value='".$gallery->getgalleryID()."'>
				<div class='editGallerybuttonDiv'>
					<input class = 'editPostButton'type='submit' name='editGalleryButton' value='Edit Gallery'>
				</div>
			</form>
		</div>";
		}
		return $editForm;
	}

	/**
	 * @return string
	 * creates the menu to post a picture in the users gallery
	 */
	private function getGalleryButtons() {

		return "<div class = 'divGallery'>
					<form class = 'galleryForm' method='post' enctype='multipart/form-data'>
						<label>Title :</label>
						<input type='text' size='20' maxlength='34' name='" . self::$galleryName . "' id='" . self::$galleryName . "' value= ''/>
						<label>Description :</label>
						<textarea class = 'posttextarea' name='" . self::$description . "' rows='3' cols='25'></textarea>
						<label class = 'piclabel'></label>
						<input class = 'picfile' type='file' name='" . self::$galleryFile . "' id='" . self::$galleryFile . "'>
						<input class = 'uploadgalleryButton' type='submit' name='" . self::$galleryButton . "' value='Upload Picture'>
					</form>
				</div>";
	}

	/**
	 * @param member string
	 * @param loginUser string
	 * @return string
	 * handles and return the gallery
	 */
	private function ShowGalleryPost(\gallery\GalleryArray $galleryArray, $member, $loginUser) {
			
		$this->allGallery = "<div class ='divHoleGallery'>";

		foreach ($galleryArray->get() as $gallery) {

			$this -> allGallery .= 
			
			"<div class='aGalerySet'>
				<div class='divgallerypic'>
					<form  class='formgallery' method='post' enctype='multipart/form-data'>
						<a class = 'divgalleryA'
						href = '?".self::$userGallery."=".$gallery->getgalleryUserName()."&amp;".self::$gallery_href."=" .$gallery -> getgalleryID().
													"' title = 'gallery' name = ".self::$gallery_href.">
						<img class = 'gallerypic' 
							src ='".self::$uploadPath."/" . $gallery -> getgalleryUserName() ."/".self::$galleryPath."/".self::$thumbnail."/" .
																								$gallery -> getgalleryURL() . "' alt = 'pic'></a>
						<p class='titleClass'>" . $gallery -> getgalleryPicName() ."</p>
					</form>
				</div>";
										
					if($loginUser == $member || $loginUser == self::$admin){
						$this->allGallery .= $this -> doDeleteAndEditGalleryButton($gallery -> getgalleryID(), $gallery->getgalleryPicName());
					}
					$this->allGallery .= "</div>";
		}
		$this -> allGallery .="</div>";
		return $this -> allGallery;
	}
}