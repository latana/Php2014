<?php

namespace galleryModel;

require_once 'DAL/galleryDAL.php';

class GalleryModel {

	private $galleryDAL;
	
	private $classImgPreparer;

	public function __construct() {

		$this -> galleryDAL = new \galleryDAL\GalleryDAL();
		$this->classImgPreparer = new \imgPreparer\ImgPreparer();
	}

	public function handleGalleryPic($galleryPic, $userName) {

		//return $this -> galleryDAL -> handleGalleryPic($galleryPic, $userName);
	}

	public function deletePic($picID) {

		$this -> galleryDAL -> deleteGalleryPic($picID);
	}
	
	public function updatePic($picID, $newTitle ,$newComment){
		
		$this-> galleryDAL->updateGalleryPic($picID, $newTitle, $newComment);
	}
	
	public function saveGalleryPic($pic, $loginUser){
		
		return $this->galleryDAL->saveGalleryPic($pic, $loginUser);
	}

	public function saveGallery($loginUser, $picName, $picURL, $picComment) {

		$this -> galleryDAL -> saveGallery($loginUser, $picName, $picURL, $picComment);
	}

	public function loadGallery($loginUser) {

		return $this -> galleryDAL -> loadGallery($loginUser);
	}

	public function getPicByID($picID) {

		return $this -> galleryDAL -> getPicByID($picID);
	}
	
		public function showGalleryComments($picID) {

		return $this -> galleryDAL -> showGalleryComments($picID);
	}
	
// kopia
	public function validatePic($pic) {

		$allowedExts = array("jpeg", "jpg", "png");
		$temp = explode(".", $pic["name"]);
		$extension = end($temp);

		if ((($pic["type"] == "image/jpeg") ||
		($pic["type"] == "image/jpg") ||
		($pic["type"] == "image/png")) &&
		($pic["size"] < 2000000) && in_array($extension, $allowedExts)) {
			return true;
		}
		return false;
	}

}
