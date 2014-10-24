<?php

namespace galleryDAL;

require_once 'objects/gallery.php';
require_once 'objects/comment.php';
require_once 'imgPreparer.php';
require_once 'settings.php';

class GalleryDAL extends \connectDB\ConnectDB {
	
	/**
	 * @var object
	 */
	private $classImgPreparer;
	
	/**
	 * @var object
	 */
	private $classUserArray;
	
	/**
	 * @var object
	 */
	private $classGalleryArray;
	
	/**
	 * @var object
	 */
	private $classCommentArray;
	
	/**
	 * @var object
	 */
	private $classComment;
	
	/**
	 * @var object
	 */
	private $classGallery;
	
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
	private static $picName;
	
	/**
	 * @var string
	 */	
	private static $picPath;
	
	/**
	 * @var string
	 */	
	private static $picComment;
	
	/**
	 * @var string
	 */	
	private static $galleryTableName;
	
	/**
	 * @var string
	 */	
	private static $thumbnail = "thumbnail";
	
	/**
	 * @var string
	 */	
	private static $uploadPath;
	
	/**
	 * @var string
	 */	
	private static $galleryPath;
	
	/**
	 * @var string
	 */	
	private static $tmp_name;
	
	/**
	 * @var string
	 */	
	private static $type;

	public function __construct() {

		$this->classImgPreparer = new \imgPreparer\ImgPreparer();
		
		self::$uploadPath = \settings\Settings::$uploadPath;
		self::$tmp_name = \settings\Settings::$tmp_name;
		self::$type = \settings\Settings::$type;
		self::$galleryPath = \settings\Settings::$galleryPath;
		
		self::$galleryTableName = \settings\Settings::$galleryTableName;
		self::$picComment = \settings\Settings::$picComment;
		self::$picPath = \settings\Settings::$picPath;
		self::$picName = \settings\Settings::$picName;
		self::$username = \settings\Settings::$username;
		self::$galleryID = \settings\Settings::$galleryID;
	}

	/**
	 * @param loginUser string
	 * @return object
	 * return all users gallery
	 */
	public function loadGallery($loginUser) {

		if ($this -> OpenDataBase()) {
			$selectSql = "SELECT `".self::$galleryID."`, `".self::$username."`, `".self::$picName."`, `".self::$picPath."`, `".self::$picComment."`
							  									FROM `".self::$galleryTableName."` WHERE `".self::$username."` = ? ORDER BY `Date` DESC";

			$stmt = $this -> GetDataBase() -> prepare($selectSql);
			$stmt -> bind_param("s", $loginUser);
			$stmt -> execute();
			$stmt -> store_result();
			$stmt -> bind_result($galleryID, $galleryUserName, $galleryPicName, $galleryURL, $galleryPicComment);
			
			$this -> classGalleryArray = new \gallery\GalleryArray();

			while ($stmt -> fetch()) {
				$this -> classGallery = new \gallery\Gallery($galleryID, $galleryUserName, $galleryPicName, $galleryURL, $galleryPicComment);
				$this -> classGalleryArray -> add($this -> classGallery);
			}
			$this -> CloseDataBase();

			return $this -> classGalleryArray;
		}
	}

	/**
	 * @param pic array
	 * @param loginUser string
	 * @return string
	 * save's the picture to the server and creats folders if none exist
	 */
	public function saveGalleryPic($pic, $loginUser) {

		$folderPath = self::$uploadPath."/" . $loginUser . "/".self::$galleryPath."/";
		$this -> classImgPreparer->createFolder($folderPath, $loginUser);

		if (is_dir($folderPath . self::$thumbnail) == false) {
			mkdir($folderPath . self::$thumbnail, 0755);
		}

		$newPicName = $this -> classImgPreparer->setPicName($folderPath, $pic);

		move_uploaded_file($pic[self::$tmp_name], $folderPath . $newPicName);

		copy($folderPath . $newPicName, $folderPath . self::$thumbnail."/" . $newPicName);

		$imgPath = $folderPath . self::$thumbnail."/" . $newPicName;

		$dest_imagex = 100;

		$this -> classImgPreparer->makeThumbnail($imgPath, $pic[self::$type], $dest_imagex);

		return $newPicName;
	}

	/**
	 * @param loginUser string
	 * @param picName string
	 * @param picURL string
	 * @param @picDescription
	 * saves the information about the picture into the database
	 */
	public function saveGallery($loginUser, $picName, $picURL, $picDescription) {

		if ($this -> OpenDataBase()) {
			$insertSql = "INSERT INTO ".self::$galleryTableName."
							(".self::$username.", ".self::$picName.", ".self::$picPath.", ".self::$picComment.") VALUES (?,?,?,?)";
							
			$stmt = $this -> GetDataBase() -> prepare($insertSql);
			$stmt -> bind_param("ssss", $loginUser, $picName, $picURL, $picDescription);
			$stmt -> execute();
			$stmt -> store_result();
			$stmt -> fetch();
			$this -> CloseDataBase();
		}
	}

	/**
	 * @param picID string
	 * @param userName string
	 * delete the picture from the database
	 */
	public function deleteGalleryPic($picID, $userName) {

		if ($this -> OpenDataBase()) {
			$selectSql = "DELETE FROM `".self::$galleryTableName."` WHERE `".self::$galleryID."` = ? AND `".self::$username."` = ?";
			$stmt = $this -> GetDataBase() -> prepare($selectSql);
			$stmt -> bind_param('ss', $picID, $userName);
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
	 * @param picID string
	 * @param userName string
	 * delete picture for admin in database
	 */
	public function adminDeleteGalleryPic($picID, $userName) {

		if ($this -> OpenDataBase()) {
				$selectSql = "DELETE FROM `".self::$galleryTableName."` WHERE `".self::$galleryID."` = ?";
				$stmt = $this -> GetDataBase() -> prepare($selectSql);
				$stmt -> bind_param('s', $picID);
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
	 * @param picID string
	 * @param newTitle string
	 * @param newComment string
	 * @param userName string
	 * updates the gallery information in database
	 */
	public function updateGalleryPic($picID, $newTitle, $newComment, $userName){
		
		if ($this -> OpenDataBase()) {
				$selectSql = "UPDATE `".self::$galleryTableName."` SET `".self::$picName."`= ?,`".self::$picComment."`= ? WHERE `".self::$galleryID."` = ?
																													AND `".self::$username."`= ?";
				$stmt = $this -> GetDataBase() -> prepare($selectSql);
				$stmt -> bind_param('ssis', $newTitle, $newComment, $picID, $userName);
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
	 * @param picID string
	 * @param newTitle string
	 * @param newComment string
	 * @param userName string
	 * update picture information for admin in database
	 */
	public function adminUpdateGalleryPic($picID, $newTitle, $newComment, $userName){
		
		if ($this -> OpenDataBase()) {
				$selectSql = "UPDATE `".self::$galleryTableName."` SET `".self::$picName."`= ?,`".self::$picComment."`= ? WHERE `".self::$galleryID."` = ?";
				$stmt = $this -> GetDataBase() -> prepare($selectSql);
				$stmt -> bind_param('ssi', $newTitle, $newComment, $picID);
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
	 * @param picID string
	 * @return bool|object
	 * if no row is affected then return false
	 */
	public function getPicByID($picID) {

		if ($this -> OpenDataBase()) {
			$selectSql = "SELECT `".self::$galleryID."`, `".self::$username."`, `".self::$picName."`, `".self::$picPath."`, `".self::$picComment.
									"` FROM `".self::$galleryTableName."` WHERE `".self::$galleryID."` = ?";
			$stmt = $this -> GetDataBase() -> prepare($selectSql);
			$stmt -> bind_param("s", $picID);
			$stmt -> execute();
			$stmt -> store_result();
			$stmt -> bind_result($galleryID, $galleryUserName, $galleryPicName, $galleryURL, $galleryPicComment);
			
			if($stmt->num_rows == 0){
				return false;
			}		
			$this -> classGalleryArray = new \gallery\GalleryArray();

			while ($stmt -> fetch()) {
				$this -> classGallery = new \gallery\Gallery($galleryID, $galleryUserName, $galleryPicName, $galleryURL, $galleryPicComment);
				$this -> classGalleryArray -> add($this -> classGallery);
			}
			$this -> CloseDataBase();
			
			return $this -> classGalleryArray;
		}
	}
}