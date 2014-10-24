<?php

namespace galleryCommentDAL;

require_once 'objects/comment.php';

class GalleryCommentDAL extends \connectDB\ConnectDB {

	/**
	 * @var object
	 */
	private $classCommentArray;
	
	/**
	 * @var object
	 */
	private $classComment;
	
	/**
	 * @var string
	 */
	private static $GCtableName;
	
	/**
	 * @var string
	 */
	private static $galleryID;
	
	/**
	 * @var string
	 */
	private static $username;
	
	/**
	 * @var string
	 */
	private static $galleryComment;
	
	/**
	 * @var string
	 */
	private static $galleryCommentID;
	
	
	public function __construct(){
		
		self::$galleryCommentID = \settings\Settings::$galleryCommentID;
		self::$galleryComment = \settings\Settings::$galleryComment;
		self::$username = \settings\Settings::$username;
		self::$galleryID = \settings\Settings::$galleryID;
		self::$GCtableName = \settings\Settings::$GCtableName;
	}
	/**
	 * @param picID
	 * @return object
	 * stors the value from the database into object 
	 */
	public function showGalleryComments($picID) {

		if ($this -> OpenDataBase()) {
			$selectSql = "SELECT `".self::$galleryCommentID."`, `".self::$galleryID."`, `".self::$username."`, `".self::$galleryComment."`
							  FROM `".self::$GCtableName."` WHERE `".self::$galleryID."` = ? ORDER BY `Date` DESC";

			$stmt = $this -> GetDataBase() -> prepare($selectSql);
			$stmt -> bind_param("s", $picID);
			$stmt -> execute();
			$stmt -> store_result();
			$stmt -> bind_result($galleryCommentID, $galleryID, $userName, $picComment);

			$this -> classCommentArray = new \comment\CommentArray();

			while ($stmt -> fetch()) {
				$this -> classComment = new \comment\Comment($galleryCommentID, $galleryID, $userName, $picComment);
				$this -> classCommentArray -> add($this -> classComment);
			}
			$this -> CloseDataBase();

			return $this -> classCommentArray;
		}
	}
  
  	/**
	 * @param loginUser string
	 * @param picID string
	 * @param picComment string
	 * stores the value into database
	 */
  	public function saveGalleryComment($loginUser, $picID, $picComment) {

		if ($this -> OpenDataBase()) {
			$insertSql = "INSERT INTO ".self::$GCtableName." (".self::$galleryID.",".self::$username." , ".self::$galleryComment.") VALUES (?,?,?)";
			$stmt = $this -> GetDataBase() -> prepare($insertSql);
			$stmt -> bind_param("sss", $picID, $loginUser, $picComment);
			$stmt -> execute();
			$stmt -> store_result();
			$stmt -> fetch();
			$this -> CloseDataBase();
		}
	}
	
	/**
	 * @param comment string
	 * @param id string
	 * @param userName string
	 * Updates the galleryComment in database
	 */
	public function updateComment($comment, $id, $userName) {

		if ($this -> OpenDataBase()) {
				$selectSql = "UPDATE ".self::$GCtableName." SET `".self::$galleryComment."`= ? WHERE `".self::$galleryCommentID."`= ?
																									AND `".self::$username."` = ?";
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
	 * @param comment string
	 * @param id string
	 * @param username string
	 * update comment for admin in database
	 */
	public function adminUpdateComment($comment, $id, $userName) {

		if ($this -> OpenDataBase()) {
				$selectSql = "UPDATE ".self::$GCtableName." SET `".self::$galleryComment."`= ? WHERE `".self::$galleryCommentID."`= ?";
				$stmt = $this -> GetDataBase() -> prepare($selectSql);
				$stmt -> bind_param('si', $comment, $id);
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
	 * delete the comment for admin from database
	 */
	public function adminDeleteComment($id, $userName) {

		if ($this -> OpenDataBase()) {
			$selectSql = "DELETE FROM `".self::$GCtableName."` WHERE `".self::$galleryCommentID."` = ?";
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
	 * @param id string
	 * @param userName
	 * delete comment from database
	 */
	public function deleteComment($id, $userName) {

		if ($this -> OpenDataBase()) {
				$selectSql = "DELETE FROM `".self::$GCtableName."` WHERE `".self::$galleryCommentID."` = ? AND `".self::$username."` = ?";
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
}