<?php

namespace galleryDAL;

require_once 'objects/post.php';
require_once 'objects/gallery.php';
require_once 'objects/comment.php';
require_once 'imgPreparer.php';

class GalleryDAL extends \connectDB\ConnectDB {
	
	private $classImgPreparer;
	
	private $classPostArray;

	private $classPost;

	private $classUserArray;

	private $classGalleryArray;

	private $classCommentArray;

	private $classComment;

	private $classGallery;

	private $classLoginModel;

	public function __construct() {

		$this -> classPostArray = new \post\PostArray();
		$this -> classGalleryArray = new \gallery\GalleryArray();
		$this -> classLoginModel = new \loginModel\LoginModel();
		$this -> classCommentArray = new \comment\CommentArray();
		$this->classImgPreparer = new \imgPreparer\ImgPreparer();		
	}

	public function loadGallery($loginUser) {

		if ($this -> OpenDataBase()) {
			$selectSql = "SELECT `GalleryID`, `Username`, `Picname`, `URL`, `Piccomment`
							  FROM `gallery` WHERE `Username` = ? ORDER BY `Date` DESC";

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

	public function saveGalleryPic($pic, $loginUser) {

		$folderPath = "upload/" . $loginUser . "/gallery/";
		$this -> classImgPreparer->createFolder($folderPath, $loginUser);

		if (is_dir($folderPath . "thumbnail") == false) {
			mkdir($folderPath . "thumbnail", 0755);
		}

		$newPicName = $this -> classImgPreparer->setPicName($folderPath, $pic);

		move_uploaded_file($pic["tmp_name"], $folderPath . $newPicName);

		copy($folderPath . $newPicName, $folderPath . "thumbnail/" . $newPicName);

		$imgPath = $folderPath . "thumbnail/" . $newPicName;

		$dest_imagex = 100;

		$this -> classImgPreparer->makeThumbnail($imgPath, $pic['type'], $dest_imagex);

		return $newPicName;

	}

	public function saveGallery($loginUser, $picName, $picURL, $picComment) {

		if ($this -> OpenDataBase()) {
			$insertSql = "INSERT INTO gallery (Username, Picname, URL, Piccomment) VALUES (?,?,?,?)";
			$stmt = $this -> GetDataBase() -> prepare($insertSql);
			$stmt -> bind_param("ssss", $loginUser, $picName, $picURL, $picComment);
			$stmt -> execute();
			$stmt -> store_result();
			$stmt -> fetch();
			//$id = $stmt -> insert_id;
			//return $id;
			$this -> CloseDataBase();
		}
	}

	public function deleteGalleryPic($picID) {

		if ($this -> OpenDataBase()) {
			$selectSql = "DELETE FROM `gallery` WHERE `GalleryID` = ? ";
			$stmt = $this -> GetDataBase() -> prepare($selectSql);
			$stmt -> bind_param('s', $picID);
			$stmt -> execute();
			$this -> CloseDataBase();
		}
	}
	
	public function updateGalleryPic($picID, $newTitle, $newComment){
		
		if ($this -> OpenDataBase()) {
			$selectSql = "UPDATE `gallery` SET `Picname`= ?,`Piccomment`= ? WHERE `GalleryID` = ?";
			$stmt = $this -> GetDataBase() -> prepare($selectSql);
			$stmt -> bind_param('ssi', $newTitle, $newComment, $picID);
			$stmt -> execute();
			$this -> CloseDataBase();
		}
	}

	public function getPicByID($picID) {

		if ($this -> OpenDataBase()) {
			$selectSql = "SELECT `GalleryID`, `Username`, `Picname`, `URL`, `Piccomment` FROM `gallery` WHERE `GalleryID` = ?";
			$stmt = $this -> GetDataBase() -> prepare($selectSql);
			$stmt -> bind_param("s", $picID);
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

	public function showGalleryComments($picID) {

		if ($this -> OpenDataBase()) {
			$selectSql = "SELECT `GalleryCommentID`, `GalleryID`, `Username`, `GalleryComment`
							  FROM `GalleryComment` WHERE `GalleryID` = ? ORDER BY `Date` DESC";

			$stmt = $this -> GetDataBase() -> prepare($selectSql);
			$stmt -> bind_param("s", $picID);
			$stmt -> execute();
			$stmt -> store_result();
			$stmt -> bind_result($galleryCommentID, $galleryID, $userName, $picComment);

			$this -> classCommnetArray = new \comment\CommentArray();

			while ($stmt -> fetch()) {
				$this -> classComment = new \comment\Comment($galleryCommentID, $galleryID, $userName, $picComment);
				$this -> classCommentArray -> add($this -> classComment);
			}
			$this -> CloseDataBase();

			return $this -> classCommentArray;
		}
	}
}
