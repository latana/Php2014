<?php

namespace galleryPageView;

require_once 'post/postView.php';

class GalleryPageView{

	private static $galleryFile = "galleryFile";

	private static $galleryButton = "gallerybutton";

	private static $gallery_href = "gallery";

	private static $galleryName = "galleryName";

	private static $description = "description";
	
	private static $editTitle = "editTitle";

	private static $editDescription = "editDescription";

	private $selectedPic;

	private $allGallery;

	private $delete = "Delete";
	
	private $edit = "edit";
	
	private $picComment = "picComment";
	
	private $commentPicButton = "commentPicButton";
	
	private static $editGalleryButton = "editCommentPicButton";
	
	private $classPostView;
	
	private $classFrontPageView;

	public function __construct(\frontPageView\FrontPageView $classFrontPageView) {

		$this->classPostView = new \postView\PostView();
		$this->classFrontPageView = $classFrontPageView;
	}

	public function getMembersGallery(){
		$urlName = explode("&",$_SERVER['REQUEST_URI']);
		
		if(empty($urlName)){
			return false;			
		}
		return $urlName[1];
		
	}

	public function userWantToLookAtPic() {

		if (isset($_GET[self::$gallery_href])) {
			return true;
		}
		return false;
	}

	public function getGalleryID() {

		if (isset($_GET[self::$gallery_href])) {
			return $_GET[self::$gallery_href];
		}
	}

	public static function tryToUploadGallery() {

		if (isset($_POST[self::$galleryButton])) {
			return true;
		}
		return false;
	}

	public function getGalleryName() {

		if (isset($_POST[self::$galleryButton])) {
			return $_POST[self::$galleryName];
		}
	}

	public function getDescription() {

		if (isset($_POST[self::$galleryButton])) {
			return $_POST[self::$description];
		}
	}

	public function getGalleryPic() {

		if ($_FILES[self::$galleryFile]['size'] > 0) {
			return $_FILES[self::$galleryFile];
		}
	}

	public function userWantToDeletePic() {

		if (isset($_POST[$this -> delete])) {
			return true;
		}
		return false;
	}
	
	public function userWantToEditPic() {

		if (isset($_POST[$this -> edit])) {
			return true;
		}
		return false;
	}
	
	public function userTriedToEditPic() {

		if (isset($_POST[$this -> edit])) {
			return true;
		}
		return false;
	}

	public function getPicID() {

		if (isset($_POST[$this -> delete])) {
			return $_POST[$this -> delete];
		}
		if(isset($_POST[$this->edit])){
			return $_POST[$this->edit];
		}
		return false;
	}
	
	public function userWantToCommentPic(){
		
		if(isset($_POST[$this->commentPicButton])){
			return true;
		}
		return false;
	}
	
	public function getPicComment(){
		
		if(isset($_POST[$this->commentPicButton])){
			return trim($_POST[$this->picComment]);
		}
		return false;
	}
	
	public function getEditGalleryButton(){
		
		if(isset($_POST[self::$editGalleryButton])){
			return true;
		}
		return false;
	}
	
	public function getEditGalleryButtonID(){
		
		if(isset($_POST[self::$editGalleryButton])){
			return $_POST[self::$editGalleryButton];
		}
		return false;
	}
	
	public function getNewTitle(){
		
		if(isset($_POST[self::$editTitle])){
			return $_POST[self::$editTitle];
		}
		return false;
	}
	
	public function getNewDescription(){
	
		if(isset($_POST[self::$editDescription])){
			return $_POST[self::$editDescription];
		}
		return false;	
	}

	public function doDeleteAndEditGalleryButton($galleryID) {

		$galleryButton = "<div class = 'divedit'>
								<form method='POST'>
									<input type='hidden' value='" . $galleryID . "' name='" . $this -> edit . "' />
									<input type='submit' value='Edit' />
								</form>
							</div>";	

		$galleryButton .= "<div class = 'divdelete'>
								<form method='POST'>
									<input type='hidden' value='" . $galleryID . "' name='" . $this -> delete . "' />
									<input type='submit' value='Delete' />
								</form>
						  </div>";
			
		return $galleryButton;
	}

	public function showSelectedPic(\gallery\GalleryArray $galleryArray, \comment\CommentArray $commentArray, \user\UserArray $userArray, $loginUser, $admin) {

		foreach ($galleryArray->get() as $gallery) {
			
			$this -> selectedPic = "
			
			<div class='selectedpicdiv'>
				<form method='POST'>
					<div class = 'Xbutton'>
						<a href = '?usergallery&".$gallery->getgalleryUserName()."' title = 'Xbutton'name = 'Xbutton' value = 'X'>X</a>
					</div>
					<img class = 'gallerypic' src='upload/" . $gallery -> getgalleryUserName(). "/gallery/" . $gallery -> getgalleryURL() . "'alt = 'pic''>
					<p>".$gallery->getgalleryPicComment()."</p>
				</form>
				<form method='POST'>
					<textarea class = 'gallerytextarea' type='text' name='".$this->picComment."' rows='3' cols='25'></textarea>
					<input type='hidden' value='" . $gallery->getgalleryID() . "' name='" . $this->commentPicButton . "' />
					<input class = 'commentPicButton' type='submit' value='Comment'>
				</form>
			</div>";
					
			foreach ($commentArray->get() as $comment) {
				if($gallery->getgalleryID() == $comment->getGalleryID()){
					$this->selectedPic .= $this->classPostView->showComment($commentArray, $userArray, $loginUser, $admin);	
					break;
				}
			}
		}
	}

	public function showGalleryPage(\gallery\GalleryArray $galleryArray, $loginUser, $member, $editForm) {

		$content = "<div class = 'divloggedin'>
						<h2 class = 'loginlogged'> " . $loginUser . " Logged in</h2>
					</div>";
				
		$content .=	$this -> classFrontPageView->navigationButtons($loginUser);
				
				if($loginUser == $member){
					$content .= $this -> getGalleryButtons();
				}
				$content .= $this -> selectedPic . $editForm . $this -> showGalleryPost($galleryArray, $member, $loginUser);

		$this -> classFrontPageView->rendHTML($content);
	}
	
	public function getEditMenu(\gallery\GalleryArray $galleryArray){
		
		foreach ($galleryArray->get() as $gallery) {
		
		$editForm = 
		
		"<div class = 'divEditGallery'>
			<form class = 'EditgalleryForm' method='post' enctype='multipart/form-data''>
				<label>New Title :</label>
				<input type='text' size='20' name='".self::$editTitle."'id='".self::$editTitle."'value='".$gallery->getgalleryPicName()."'/>
				<label>New Description :</label>
				<textarea class='gallerytextarea'type='text'name='".self::$editDescription."'rows='3' cols='25'>".$gallery->getgalleryPicComment()."</textarea>
				<input type='hidden'class='uploadgalleryButton'type='submit' name='".self::$editGalleryButton."'value='".$gallery->getgalleryID()."'>
				<input class = 'uploadgalleryButton'type='submit' name='stuff' value='Edit'>
			</form>
			<form enctype='multipart/form-data' method='post'>
				<input type='submit' value='X'>
			</form>
		</div>";
		} 
		return $editForm;
	}

	private function getGalleryButtons() {

		return "<div class = 'divGallery'>
					<form class = 'galleryForm' method='post' enctype='multipart/form-data''>
						<label>Title :</label>
						<input type='text' size='20' name='" . self::$galleryName . "' id='" . self::$galleryName . "' value= ''/>
						<label>Description :</label>
						<textarea class = 'gallerytextarea' type='text' name='" . self::$description . "' rows='3' cols='25'></textarea>
						<label class = 'piclabel' for='file'></label>
						<input class = 'picfile' type='file' name='" . self::$galleryFile . "' id='" . self::$galleryFile . "'>
						<input class = 'uploadgalleryButton'type='submit' name='" . self::$galleryButton . "' value='Upload'>
					</form>
				</div>";
	}

	private function ShowGalleryPost(\gallery\GalleryArray $galleryArray, $member, $loginUser) {

		foreach ($galleryArray->get() as $gallery) {

			$this -> allGallery .= "<div class='divgallerypic'>
										<form method='post' enctype='multipart/form-data'>
											<a href = '?usergallery&" . $gallery->getgalleryUserName() ."&".self::$gallery_href . "=" .
											$gallery -> getgalleryID() . "' title = 'gallery' name = " .
											self::$gallery_href . " value = ". $gallery -> getgalleryID() . ">
											<img class = 'gallerypic' src ='upload/" . $gallery -> getgalleryUserName() . "/gallery/thumbnail/" .
											$gallery -> getgalleryURL() . "'alt = 'pic'></a>
											<p class='titleClass'>" . $gallery -> getgalleryPicName() ."</p>
										</form>
									</div>";
										
					if($loginUser == $member || $loginUser == "Admin"){
						$this->allGallery .= $this -> doDeleteAndEditGalleryButton($gallery -> getgalleryID());
					}
		}
		return $this -> allGallery;
	}
}