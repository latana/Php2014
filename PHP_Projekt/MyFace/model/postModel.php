<?php

namespace postModel;

require_once 'DAL/postDAL.php';
require_once 'DAL/imgPreparer.php';

class PostModel {

	/**
	 * @var object
	 */
	private $postDAL;
	
	/**
	 * @var object
	 */
	private $imgPrepater;
	
	/**
	 * @var string
	 */
	private static $admin;

	public function __construct() {

		$this -> postDAL = new \postDAL\PostDAL();
		$this->imgPreparer = new \imgPreparer\ImgPreparer();
		
		self::$admin = \settings\Settings::$admin;
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

	/**
	 * @param userName string
	 * @param comment string
	 * @param picName string
	 * @return bool
	 */
	public function savePost($userName, $comment, $picName) {

		if(is_string($userName) && is_string($comment)){
			$this -> postDAL -> savePost($userName, $comment, $picName);
		}
		return false;
	}

	/**
	 * @param newComment string
	 * @param postID string
	 * @param userName string
	 * @return bool
	 * check if the logged in user is admin.
	 * if not the user cannot edit other users posts
	 */
	public function updatePost($newComment, $postID, $userName) {
			
		if(is_string($newComment) && is_numeric($postID) && is_string($userName)){
		
			if($userName == self::$admin){
				return $this -> postDAL -> adminUpdatePost($newComment, $postID, $userName);
			}
			else{
				return $this -> postDAL -> updatePost($newComment, $postID, $userName);
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
	public function deletePost($postID, $userName) {

		if(is_numeric($postID) && is_string($userName)){
			
			if($userName == self::$admin){
				return $this -> postDAL -> adminDeletePost($postID, $userName);
			}
			else{
				return $this -> postDAL -> deletePost($postID, $userName);
			}
		}
		return false;
	}

	/**
	 * @return object
	 * returns all the posts
	 */
	public function loadPost() {

		return $this -> postDAL -> loadPost();
	}

	/**
	 * @param loginUser string
	 * @return object|bool
	 */
	public function loadUserPost($loginUser) {

		if(is_string($loginUser)){
			return $this -> postDAL -> loadUserPost($loginUser);
		}
		return false;
	}

	/**
	 * @param array
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
	 * @param loginUser string
	 */
	public function savePostPic($pic, $loginUser){

		if(is_string($loginUser)){
			return $this->postDAL->savePostPic($pic, $loginUser);
		}
		return false;
	}
	
	/**
	 * @param userName string
	 * @return bool 
	 */
	public function deleteUser($userName){
		
		if(is_string($userName)){
			$this->postDAL->deleteUser($userName);
		}
		return false;
	}
}