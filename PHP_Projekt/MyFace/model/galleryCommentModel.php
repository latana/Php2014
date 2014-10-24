<?php
namespace galleryCommentModel;

require_once 'DAL/galleryCommentDAL.php';
require_once 'settings.php';

class GalleryCommentModel {

	/**
	 * @var object
	 */
	private $galleryCommentDAL;
	
	/**
	 * @var string
	 */
	private static $admin;

	public function __construct() {

		$this -> galleryCommentDAL = new \galleryCommentDAL\GalleryCommentDAL();
		
		self::$admin = \settings\Settings::$admin;
	}
	
	/**
	 * @param picID string
	 * @return object|bool
	 */
	public function showGalleryComments($picID) {
		
		if(is_numeric($picID)){
			return $this -> galleryCommentDAL -> showGalleryComments($picID);	
		}
		return false;
	}

	/**
	 * @param newComment string
	 * @param postID string
	 * @param userName
	 * @return bool
	 * check if the logged in user is admin.
	 * if not the user cannot edit other users comments
	 */
	public function updateComment($newComment, $postID, $userName) {

		if(is_string($newComment) && is_numeric($postID) && is_string($userName)){
			
			if($userName == self::$admin){
				return $this -> galleryCommentDAL -> adminUpdateComment($newComment, $postID, $userName);	
			}
			else{
				return $this -> galleryCommentDAL -> updateComment($newComment, $postID, $userName);
			}
		}
		return false;
	}

	/**
	 * @param postID string
	 * @param userName string
	 * @return bool
	 * check if the logged in user is admin.
	 * if not the user cannot delete other users comments
	 */
	public function deleteComment($postID, $userName) {
		
		if(is_numeric($postID) && is_string($userName)){
			
			if($userName == self::$admin){
				return $this -> galleryCommentDAL -> adminDeleteComment($postID, $userName);
			}
			else{
				return $this -> galleryCommentDAL -> deleteComment($postID, $userName);
			}
		}
		return false;
	}

	/**
	 * @param loginUser string
	 * @param picID string
	 * @param picCommnet string
	 * @return bool
	 */
	public function saveGalleryComment($loginUser, $picID, $picComment) {
		
		if(is_string($loginUser) && is_numeric($picID) && is_string($picComment)){
			$this -> galleryCommentDAL -> saveGalleryComment($loginUser, $picID, $picComment);
		}
		return false;
	}
}