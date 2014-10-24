<?php

namespace postDAL;

require_once 'objects/post.php';
require_once 'imgPreparer.php';
require_once 'settings.php';

class PostDAL extends \connectDB\ConnectDB {

	/**
	 * @var object
	 */
	private $classPostArray;

	/**
	 * @var object
	 */
	private $classPost;
	
	/**
	 * @var string
	 */
	private static $postId;
	
	/**
	 * @var string
	 */	
	private static $username;
	
	/**
	 * @var string
	 */	
	private static $comment;
	
	/**
	 * @var string
	 */	
	private static $picPath;
	
	/**
	 * @var string
	 */	
	private static $postTableName;
	
	/**
	 * @var string
	 */	
	private static $postPath;
	
	/**
	 * @var string
	 */	
	private static $uploadPath;
	
	/**
	 * @var string
	 */	
	private static $tmp_name;
	
	/**
	 * @var string
	 */
	 private static $userTableName;
	
	/**
	 * @var string
	 */	
	private static $type;
	
	/**
	 * @var string
	 */
	 private static $galleryID;
	 
	 /**
	  * @var string
	  */
	  private static $galleryComment;
	  
	 /**
	  * @var string
	  */
	  private static $galleryTableName;

	public function __construct() {

		$this->classImgPreparer = new \imgPreparer\ImgPreparer();
		
		self::$postPath = \settings\Settings::$postPath;
		self::$uploadPath = \settings\Settings::$uploadPath;
		self::$tmp_name = \settings\Settings::$tmp_name;
		self::$type = \settings\Settings::$type;
		
		self::$postTableName = \settings\Settings::$postTableName;
		self::$comment = \settings\Settings::$comment;
		self::$username = \settings\Settings::$username;
		self::$postId = \settings\Settings::$postId;
		self::$userTableName = \settings\Settings::$userTableName;
		self::$galleryID = \settings\Settings::$galleryID;
		self::$galleryComment = \settings\Settings::$galleryComment;
		self::$galleryTableName = \settings\Settings::$galleryTableName;
		self::$picPath = \settings\Settings::$picPath;
	}

	/**
	 * @param loginUser string
	 * @return object
	 * return all the users posts from the database
	 */
	public function loadUserPost($loginUser) {

		if ($this -> OpenDataBase()) {
			$selectSql = "SELECT `".self::$postId."`, `".self::$username."`, `".self::$comment."`, `".self::$picPath.
						"` FROM `".self::$postTableName."` WHERE `".self::$username."` = ? ORDER BY `Date` DESC";
			$stmt = $this -> GetDataBase() -> prepare($selectSql);
			$stmt -> bind_param("s", $loginUser);
			$stmt -> execute();
			$stmt -> store_result();
			$stmt -> bind_result($postID, $postUserName, $comment, $postPic);

			$this -> classPostArray = new \post\PostArray();

			while ($stmt -> fetch()) {
				$this -> classPost = new \post\Post($postID, $postUserName, $comment, $postPic);
				$this -> classPostArray -> add($this -> classPost);
			}
			$this -> CloseDataBase();

			return $this -> classPostArray;
		}
	}

	/**
	 * @return object
	 * return alla posts
	 */
	public function loadPost() {

		if ($this -> OpenDataBase()) {
			$selectSql = "SELECT `".self::$postId."`, `".self::$username."`, `".self::$comment."`, `".self::$picPath.
														"` FROM `".self::$postTableName."` ORDER BY `Date` DESC";
			$stmt = $this -> GetDataBase() -> prepare($selectSql);
			$stmt -> execute();
			$stmt -> store_result();
			$stmt -> bind_result($postID, $postUserName, $comment, $postPic);

			$this -> classPostArray = new \post\PostArray();

			while ($stmt -> fetch()) {
				$this -> classPost = new \post\Post($postID, $postUserName, $comment, $postPic);
				$this -> classPostArray -> add($this -> classPost);
			}
			$this -> CloseDataBase();

			return $this -> classPostArray;
		}
	}

	/**
	 * @param id string
	 * @return string
	 * get post by id
	 */
	public function getCommentValue($id) {

		if ($this -> OpenDataBase()) {

			$selectSql = "SELECT `".self::$comment."` FROM `".self::$postTableName."` WHERE `".self::$postId."` = ?";
			$stmt = $this -> GetDataBase() -> prepare($selectSql);
			$stmt -> bind_param("i", $id);
			$stmt -> execute();
			$stmt -> store_result();
			$stmt -> bind_result($db_comment);
			$stmt -> fetch();
		}
		$this -> CloseDataBase();

		return $db_comment;
	}

	/**
	 * @param pic array
	 * @return string
	 * save the picture to the server
	 */
	public function savePostPic($pic, $loginUser) {

		$folderPath = self::$uploadPath."/" . $loginUser . "/".self::$postPath."/";
	
		$this->classImgPreparer->createFolder($folderPath, $loginUser);
	
		$newPicName = $this->classImgPreparer->setPicName($folderPath, $pic);

		move_uploaded_file($pic[self::$tmp_name], $folderPath . $newPicName);
		
		$imgPath = $folderPath . $newPicName;
		
		$dest_imagex = 300;

		$this -> classImgPreparer->makeThumbnail($imgPath, $pic[self::$type], $dest_imagex);

		return $newPicName;
	}	
	
	/**
	 * @param userName stirng
	 * @param comment string
	 * @param picName string
	 * saves the users post
	 */
	public function savePost($userName, $comment, $picName) {

		if ($this -> OpenDataBase()) {
			$insertSql = "INSERT INTO ".self::$postTableName." (".self::$username.", ".self::$comment.", ".self::$picPath.") VALUES (?,?,?)";
			$stmt = $this -> GetDataBase() -> prepare($insertSql);
			$stmt -> bind_param("sss", $userName, $comment, $picName);
			$stmt -> execute();
			$stmt -> store_result();
			$stmt -> fetch();
			$this -> CloseDataBase();
		}
	}

	/**
	 * @param id string
	 * @param userName string
	 * @return bool
	 * delete the post for normal user in database
	 */
	public function deletePost($id, $userName) {

		if ($this -> OpenDataBase()) {
				$selectSql = "DELETE FROM `".self::$postTableName."` WHERE `".self::$postId."` = ? AND `".self::$username."` = ?";
				$stmt = $this -> GetDataBase() -> prepare($selectSql);
				$stmt -> bind_param('is', $id, $userName);
				$stmt -> execute();
				
				if($stmt->affected_rows == 1){
					$this -> CloseDataBase();
					return true;
				}
				else{
					$this -> CloseDataBase();
					return false;
				}
		}
		return false;
	}
	
	/**
	 * @param id string
	 * @param userName string
	 * @return bool
	 * delete the post for admin in database
	 */
	public function adminDeletePost($id, $userName) {

		if ($this -> OpenDataBase()) {
				$selectSql = "DELETE FROM `".self::$postTableName."` WHERE `".self::$postId."` = ?";
				$stmt = $this -> GetDataBase() -> prepare($selectSql);
				$stmt -> bind_param('i', $id);
				$stmt -> execute();
				
				if($stmt->affected_rows == 1){
					$this -> CloseDataBase();
					return true;
				}
				else{
					$this -> CloseDataBase();
					return false;
				}
		}
		return false;
	}

	/**
	 * @param comment string
	 * @param id int
	 * @return bool
	 * edit the post for admin in database
	 */
	public function adminUpdatePost($comment, $id, $userName) {

		if ($this -> OpenDataBase()) {
				$selectSql = "UPDATE ".self::$postTableName." SET `".self::$comment."`= ? WHERE `".self::$postId."`= ?";
				$stmt = $this -> GetDataBase() -> prepare($selectSql);
				$stmt -> bind_param('si', $comment, $id);
				$stmt -> execute();
				
				if($stmt->affected_rows == 1){
					$this -> CloseDataBase();
					return true;
				}
				else{
					$this->CloseDataBase();
					return false;
				}
		}
		return false;
	}
	
	/**
	 * @param comment string
	 * @param id string
	 * @param userName string
	 * edits the post for normal user in database
	 */
	public function updatePost($comment, $id, $userName) {

		if ($this -> OpenDataBase()) {
				$selectSql = "UPDATE ".self::$postTableName." SET `".self::$comment."`= ? WHERE `".self::$postId."`= ? AND `".self::$username."` = ?";
				$stmt = $this -> GetDataBase() -> prepare($selectSql);
				$stmt -> bind_param('sis', $comment, $id, $userName);
				$stmt -> execute();
				
				if($stmt->affected_rows == 1){
					$this -> CloseDataBase();
					return true;
				}
				else{
					$this -> CloseDataBase();
					return false;
				}
		}
		return false;
	}
	
	/**
	 * @param userName string
	 * deteles the user and everything the user have done
	 */
	public function deleteUser($userName){
		
		if ($this -> OpenDataBase()) {
			$selectSql = "DELETE FROM ".self::$userTableName." WHERE `".self::$username."` = ?";
			$stmt = $this -> GetDataBase() -> prepare($selectSql);
			$stmt -> bind_param('s', $userName);
			$stmt -> execute();
			
			$selectSql = "DELETE FROM ".self::$postTableName." WHERE `".self::$username."` = ?";
			$stmt = $this -> GetDataBase() -> prepare($selectSql);
			$stmt -> bind_param('s', $userName);
			$stmt -> execute();
			
			$selectSql = "SELECT `".self::$galleryID."` FROM `".self::$galleryTableName."` WHERE `".self::$username."` = ?";
			$stmt = $this -> GetDataBase() -> prepare($selectSql);
			$stmt -> bind_param("s", $userName);
			$stmt -> execute();
			$stmt -> store_result();
			$stmt -> bind_result($db_id);
			$stmt -> fetch();
			
			$selectSql = "DELETE FROM ".self::$galleryComment." WHERE `".self::$galleryID."` = ?";
			$stmt = $this -> GetDataBase() -> prepare($selectSql);
			$stmt -> bind_param('i', $db_id);
			$stmt -> execute();
			
			$selectSql = "DELETE FROM ".self::$galleryComment." WHERE `".self::$username."` = ?";
			$stmt = $this -> GetDataBase() -> prepare($selectSql);
			$stmt -> bind_param('s', $userName);
			$stmt -> execute();
			
			$selectSql = "DELETE FROM ".self::$galleryTableName." WHERE `".self::$username."` = ?";
			$stmt = $this -> GetDataBase() -> prepare($selectSql);
			$stmt -> bind_param('s', $userName);
			$stmt -> execute();
			
			$this -> CloseDataBase();
		}
	}
}