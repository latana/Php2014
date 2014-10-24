<?php

namespace galleryPageController;

require_once 'galleryPage/galleryPageView.php';
require_once 'model/galleryModel.php';
require_once 'model/userModel.php';
require_once 'model/galleryCommentModel.php';

class GalleryPageController {

	/**
	 * @var  object
	 */
	private $classGalleryModel;
	
	/**
	 * @var  object
	 */
	private $classGalleryPageView;
	
	/**
	 * @var  object
	 */
	private $classUserModel;
	
	/**
	 * @var  object
	 */
	private $classGalleryCommentModel;
	
	/**
	 * @var  string
	 */
	private $editForm;
	
	/**
	 * @var  string
	 */
	private $areYouSureField;
	
	/**
	 * @var string
	 */
	private $selectedPic;

	public function __construct(\frontPageView\FrontPageView $classFrontPageView, $loginUser) {
		
		$this -> classFrontPageView = $classFrontPageView;
		$this -> classGalleryModel = new \galleryModel\GalleryModel();
		$this -> classGalleryPageView = new \galleryPageView\GalleryPageView($classFrontPageView);
		$this -> classPostController = new \postController\PostController($classFrontPageView);
		$this -> classUserModel = new \userModel\UserModel();
		$this->classGalleryCommentModel = new \galleryCommentModel\GalleryCommentModel();
		$this->gallerypage($loginUser);
	}

	/**
	 * @param loginUser string
	 * check what the user does and show's
	 * the selected users gallery
	 */
	public function galleryPage($loginUser) {

		$galleryOwner = trim(strip_tags($this->classGalleryPageView->getMembersGallery()));

		if ($this -> classGalleryPageView -> userWantToLookAtPic()) {
			$this -> selectedPic = $this -> handleSelectedPic($loginUser);
		}
		if ($this -> classGalleryPageView -> userWantToDeletePic()) {
			$this->areYouSureField = $this->classGalleryPageView->areYouSureFeild($this -> classGalleryPageView -> getPicID(),
																					$this->classGalleryPageView->getDeleteTitle());
		}
		if($this->classGalleryPageView->triedToDeletePic()){	
			if($this -> classGalleryModel -> deletePic($this -> classGalleryPageView -> getDeleteUserId(), $loginUser)){
				$this->classFrontPageView->setMessage(\frontPageView\FrontPageView::DELETE_PIC);
			}
		}
		if($this->classGalleryPageView -> userWantToEditPic()){
			$picObj = $this->classGalleryModel->getPicByID($this->classGalleryPageView->getPicID());
			$this->editForm = $this->classGalleryPageView->getEditMenu($picObj);
		}
		if($this->classGalleryPageView->getEditGalleryButton()){
				$newTitle = $this->classGalleryPageView->getNewTitle();
				$newDescription = $this->classGalleryPageView->getNewDescription();
				
				if($this->validateGalleryInput($newTitle, $newDescription)){
					if($this->classGalleryModel->updatePic($this->classGalleryPageView->getEditGalleryButtonID(),
																		$newTitle, $newDescription, $loginUser)){
						$this->classFrontPageView->setMessage(\frontPageView\FrontPageView::EDIT_GALLERY_SUCCESS);
					}
				}
		}
		if ($this -> classGalleryPageView -> tryToUploadGallery()) {
			$this -> handlePic($loginUser);
		}
		
		if($this -> classUserModel ->checkIfValid($galleryOwner)){
			$this->classGalleryPageView->showGalleryNotFound($loginUser, $galleryOwner);
		}
		else{
			$this -> classGalleryPageView -> showGalleryPage($this -> classGalleryModel -> loadGallery($galleryOwner),
									$loginUser, $galleryOwner, $this->editForm, $this->areYouSureField, $this->selectedPic);
		}
	}

	/**
	 * @param loginUser string
	 * @return string,
	 * return the chosesn picture with comments.
	 */
	private function handleSelectedPic($loginUser) {

		$galleryID = trim(strip_tags($this -> classGalleryPageView -> getGalleryID()));

		$galleryArray = $this -> classGalleryModel -> getPicByID($galleryID);
		
		if($galleryArray == false){
			return $this->classGalleryPageView->showCanNotFindPic();
		}
		else{
			$this -> classPostController -> commentController($loginUser);
			
			if ($this -> classGalleryPageView -> userWantToCommentPic()) {
				if ($this -> picCommentValidater()) {
					$picComment = $this -> classGalleryPageView -> getPicComment();
					$this -> classGalleryCommentModel -> saveGalleryComment($loginUser, $galleryID, $picComment);
					$this->classGalleryPageView->reloadSelectedPic($galleryID);
				}
			}
			$commentArray = $this -> classGalleryCommentModel -> showGalleryComments($galleryID);
			$userArray = $this -> classUserModel -> loadUsers();
			return $this -> classGalleryPageView -> showSelectedPic($galleryArray, $commentArray, $userArray, $loginUser);	
		}
	}

	/**
	 * @return bool
	 * check if the comment is empty or has taggs.
	 * otherwise it returns true
	 */
	private function picCommentValidater() {
		
		if ($this -> classGalleryPageView -> getPicComment() == null) {			
			$this->classFrontPageView->setMessage(\frontPageView\FrontPageView::EMPTY_COMMENT);
			return false;
		}
		if (strip_tags($this -> classGalleryPageView -> getPicComment()) !== $this -> classGalleryPageView -> getPicComment()) {
			$this->classFrontPageView->setMessage(\frontPageView\FrontPageView::STRIP_TAGS_COMMENT);
			return false;
		}
		return true;
	}

	/**
	 * @param string
	 * validate the picture that has been posted.
	 */
	private function handlePic($loginUser) {

		if(!$this -> classGalleryPageView -> getGalleryPic()){
			$this->classFrontPageView->setMessage(\frontPageView\FrontPageView::MISSING_PIC);
			return;
		}
		if ($this -> classGalleryModel -> validatePic($this -> classGalleryPageView -> getGalleryPic())) {
			
			if($this -> classGalleryModel -> checkPicSize($this -> classGalleryPageView -> getGalleryPic())){
				
				$picTitle = $this -> classGalleryPageView -> getGalleryName();
				$picDescription = $this -> classGalleryPageView -> getDescription();
				
				if($this->validateGalleryInput($picTitle, $picDescription)){
					$picURL = $this -> classGalleryModel -> saveGalleryPic($this -> classGalleryPageView -> getGalleryPic(), $loginUser);
					$this -> classGalleryModel -> saveGallery($loginUser, $picTitle, $picURL, $picDescription);
					$this->classGalleryPageView->reloadPage();
				}
			}
			else{
				$this->classFrontPageView->setMessage(\frontPageView\FrontPageView::PIC_TO_BIG);
			}
		}
		else{
			$this->classFrontPageView->setMessage(\frontPageView\FrontPageView::PIC_VALIDATION);
		}
	}
	
	/**
	 * @param picTitle string
	 * @param picDescription string
	 * @return bool
	 * Validate the pictures title and description
	 */
	private function validateGalleryInput($picTitle, $picDescription){
		
		if($picTitle == null){
			$this->classFrontPageView->setMessage(\frontPageView\FrontPageView::MISSING_TITLE);
			return false;
		}
		if(strip_tags($picTitle) !== $picTitle){
			$this->classFrontPageView->setMessage(\frontPageView\FrontPageView::STRIP_TAGS_TITLE);
			return false;
		}
		if(strip_tags($picDescription) !== $picDescription){
			$this->classFrontPageView->setMessage(\frontPageView\FrontPageView::STRIP_TAGS_DESCRIPTION);
			return false;
		}
		return true;
	}
}