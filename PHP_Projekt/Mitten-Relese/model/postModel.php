<?php

namespace postModel;

require_once 'DAL/postDAL.php';

class PostModel {

	private $postDAL;

	public function __construct() {

		$this -> postDAL = new \postDAL\PostDAL();
	}


	public function handleProfilePic($profilePic, $userName) {

		return $this -> postDAL -> handleProfilePic($profilePic, $userName);
	}

	public function changeProfilePicture($userName, $profilePicName) {

		$this -> postDAL -> changeProfilePicture($userName, $profilePicName);
	}



	public function handlePic($pic, $userName) {

		return $this -> postDAL -> handlePic($pic, $userName);
	}

	public function savePost($userName, $comment, $picName) {

		$this -> postDAL -> savePost($userName, $comment, $picName);
	}

	public function updatePost($newComment, $postID, $userName) {

		$this -> postDAL -> updatePost($newComment, $postID, $userName);
	}

	public function deletePost($postID) {

		$this -> postDAL -> deletePost($postID);
	}

	public function loadPost() {

		return $this -> postDAL -> loadPost();
	}

	public function loadUser($loginUser) {

		return $this -> postDAL -> loadUser($loginUser);
	}
// kopia
	public function loadUsers() {

		return $this -> postDAL -> loadUsers();
	}

	public function loadUserPost($loginUser) {

		return $this -> postDAL -> loadUserPost($loginUser);
	}

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

	public function savePostPic($pic, $loginUser){
		
		return $this->postDAL->savePostPic($pic, $loginUser);
	}
	public function saveProfilePic($pic, $loginUser){
		
		return $this->postDAL->saveProfilePic($pic, $loginUser);
	}
	
	public function deleteUser($userName){
		
		$this->postDAL->deleteUser($userName);
	}
}