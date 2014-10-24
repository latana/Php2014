<?php

namespace galleryModel;

require_once 'DAL/galleryDAL.php';
require_once 'DAL/imgPreparer.php';
require_once 'settings.php';

class GalleryModel {
	
	/**
	 * @var object
	 */
	private $galleryDAL;
	
	/**
	 * @var string
	 */
	private static $admin;

	public function __construct() {

		$this -> galleryDAL = new \galleryDAL\GalleryDAL();
		$this->imgPreparer = new \imgPreparer\ImgPreparer();
		self::$admin = \settings\Settings::$admin;
	}

	/**
	 * @param picID string
	 * @param userName string
	 * @return bool
	 * check if the logged in user is admin.
	 * if not the user cannot delete other users picture
	 */
	public function deletePic($picID, $userName) {

		if(is_numeric($picID) && is_string($userName)){
			if($userName == self::$admin){
				return $this -> galleryDAL -> adminDeleteGalleryPic($picID, $userName);
			}
			else{
				return $this -> galleryDAL -> deleteGalleryPic($picID, $userName);
			}
		}
		return false;
	}
	
	/**
	 * @param picID string
	 * @param newTitle string
	 * @param newComment
	 * @param userName
	 * @return bool
	 * check if the logged in user is admin.
	 * if not the user cannot edit other users picture
	 */
	public function updatePic($picID, $newTitle ,$newComment, $userName){
		
		if(is_numeric($picID) && is_string($newTitle) && is_string($newComment) && is_string($userName)){
			if($userName == self::$admin){
				return $this-> galleryDAL->adminUpdateGalleryPic($picID, $newTitle, $newComment, $userName);
			}
			else{
				return $this-> galleryDAL->updateGalleryPic($picID, $newTitle, $newComment, $userName);
			}
		}
		return false;
	}
	
	/**
	 * @param pic array
	 * @param loginUser string
	 * @return bool
	 */
	public function saveGalleryPic($pic, $loginUser){
		
		if(is_string($loginUser)){
			return $this->galleryDAL->saveGalleryPic($pic, $loginUser);
		}
		return false;
	}

	/**
	 * @param loginUser
	 * @param picName
	 * @param picURL
	 * @param picComment
	 * @return bool
	 */
	public function saveGallery($loginUser, $picName, $picURL, $picComment) {

		if(is_string($loginUser) && is_string($picName) && is_string($picURL) && is_string($picComment)){
			$this -> galleryDAL -> saveGallery($loginUser, $picName, $picURL, $picComment);
		}
		return false;
	}

	/**
	 * @param loginuser string
	 * @return object|bool
	 */
	public function loadGallery($loginUser) {
		
		if(is_string($loginUser)){
			return $this -> galleryDAL -> loadGallery($loginUser);
		}
		return false;
	}

	/**
	 * @param picID string
	 * @return object|bool
	 */
	public function getPicByID($picID) {

		if(is_numeric($picID)){
			return $this -> galleryDAL -> getPicByID($picID);
		}
		return false;
	}
	
	/**
	 * @param pic array
	 * @return bool
	 */
	public function validatePic($pic) {

		if($this->imgPreparer->validatePic($pic)){
			return true;
		}
		return false;
	}
	
	/**
	 * @param pic array
	 * @return bool
	 */
	public function checkPicSize($pic){
		
		if($this->imgPreparer->checkPicSize($pic)){
			return true;
		}
		return false;
	}
}