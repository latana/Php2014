<?php

namespace galleryPageController;

require_once 'galleryPage/galleryPageView.php';
require_once 'model/galleryModel.php';
require_once 'model/userModel.php';
require_once 'model/galleryCommentModel.php';

class GalleryPageController {

	private $classGalleryModel;

	private $classGalleryPageView;

	private $admin;
	
	private $classUserModel;

	private $classGalleryCommentModel;
	
	private $editForm;

	public function __construct(\frontPageView\FrontPageView $classFrontPageView) {

		$this -> classGalleryModel = new \galleryModel\GalleryModel();
		$this -> classGalleryPageView = new \galleryPageView\GalleryPageView($classFrontPageView);
		$this -> classPostController = new \postController\PostController($classFrontPageView);
		$this->classUserModel = new \userModel\UserModel();
		$this->classGalleryCommentModel = new \galleryCommentModel\GalleryCommentModel();
		$this -> classLoginModel = new \loginModel\LoginModel();
		$this -> admin = $this -> classLoginModel -> getAdmin();
	}

	public function galleryPage($loginUser) {

		$galleryOwner = $this->classGalleryPageView->getMembersGallery();

		if ($this -> classGalleryPageView -> userWantToLookAtPic()) {
			$this -> handleSelectedPic($loginUser);
		}

		if ($this -> classGalleryPageView -> userWantToDeletePic()) {
			$this -> deletePic();
		}
		if($this->classGalleryPageView -> userWantToEditPic()){
			
			$picObj = $this->classGalleryModel->getPicByID($this->classGalleryPageView->getPicID());
			$this->editForm = $this->classGalleryPageView->getEditMenu($picObj);
		}
		if($this->classGalleryPageView->getEditGalleryButton()){
				$newTitle = $this->classGalleryPageView->getNewTitle();
				$newComment = $this->classGalleryPageView->getNewDescription();
				$this->classGalleryModel->updatePic($this->classGalleryPageView->getEditGalleryButtonID(), $newTitle, $newComment);
		}
		if ($this -> classGalleryPageView -> tryToUploadGallery()) {
			$this -> handlePic($loginUser);
		}
		
		$this -> classGalleryPageView -> showGalleryPage($this -> classGalleryModel -> loadGallery($galleryOwner),
																		$loginUser, $galleryOwner, $this->editForm);
	}

	private function handleSelectedPic($loginUser) {

		$galleryID = $this -> classGalleryPageView -> getGalleryID();
		$galleryArray = $this -> classGalleryModel -> getPicByID($galleryID);
		$this -> classPostController -> commentController($loginUser);
		
		if ($this -> classGalleryPageView -> userWantToCommentPic()) {
			if ($this -> picCommentValidater()) {
				$picComment = $this -> classGalleryPageView -> getPicComment();
				$this -> classGalleryCommentModel -> saveGalleryComment($loginUser, $galleryID, $picComment);
			}
		}
		$commentArray = $this -> classGalleryModel -> showGalleryComments($galleryID);
		$userArray = $this -> classUserModel -> loadUsers();
		$this -> classGalleryPageView -> showSelectedPic($galleryArray, $commentArray, $userArray, $loginUser, $this->admin);

	}

	private function picCommentValidater() {

		if ($this -> classGalleryPageView -> getPicComment() == null) {
			return false;
		}
		if (strip_tags($this -> classGalleryPageView -> getPicComment()) !== $this -> classGalleryPageView -> getPicComment()) {
			return false;
		}
		return true;
	}

	private function deletePic() {

		$this -> classGalleryModel -> deletePic($this -> classGalleryPageView -> getPicID());
	}

	private function handlePic($loginUser) {

		if ($this -> classGalleryModel -> validatePic($this -> classGalleryPageView -> getGalleryPic())) {

			$picName = $this -> classGalleryPageView -> getGalleryName();
			$picComment = $this -> classGalleryPageView -> getGalleryComment();
			$picURL = $this -> classGalleryModel -> saveGalleryPic($this -> classGalleryPageView -> getGalleryPic(), $loginUser);
			$this -> classGalleryModel -> saveGallery($loginUser, $picName, $picURL, $picComment);
		}
	}

	public function getGalleryView() {
		return $this -> classGalleryPageView;
	}

}
