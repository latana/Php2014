<?php

namespace postDAL;

require_once 'objects/post.php';
require_once 'objects/user.php';
require_once 'objects/gallery.php';
require_once 'objects/comment.php';

class PostDAL extends \connectDB\ConnectDB {

	private $classPostArray;

	private $classPost;

	private $classUserArray;

	private $classUser;

	private $classGalleryArray;

	private $classCommentArray;

	private $classComment;

	private $classGallery;

	private $classLoginModel;

	private static $admin = "Admin";

	public function __construct() {

		$this -> classPostArray = new \post\PostArray();
		$this -> classUserArray = new \user\UserArray();
		$this -> classGalleryArray = new \gallery\GalleryArray();
		$this -> classLoginModel = new \loginModel\LoginModel();
		$this -> classCommentArray = new \comment\CommentArray();
	}

	/**
	 * @return postArray
	 * Skriver ut användarens alla poster i daturms ordning.
	 */
	public function loadUserPost($loginUser) {

		if ($this -> OpenDataBase()) {
			$selectSql = "SELECT `PostID`, `Username`, `Comment`, `URL` FROM `Post` WHERE `Username` = ? ORDER BY `Date` DESC";
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
	 * @return postArray
	 * Skriver ut alla poster i daturms ordning.
	 */
	public function loadPost() {

		if ($this -> OpenDataBase()) {
			$selectSql = "SELECT `PostID`, `Username`, `Comment`, `URL` FROM `Post` ORDER BY `Date` DESC";
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

	public function loadUser($loginUser) {

		if ($this -> OpenDataBase()) {
			$selectSql = "SELECT `Username`, `Password`, `ProfilePic` FROM `User` WHERE `Username` = ?";
			$stmt = $this -> GetDataBase() -> prepare($selectSql);
			$stmt -> bind_param("s", $loginUser);
			$stmt -> execute();
			$stmt -> store_result();
			$stmt -> bind_result($userName, $password, $profilePic);
			$this -> classUserArray = new \user\UserArray();
			$stmt -> fetch();
			
				$this -> classUser = new \user\User($userName, $password, $profilePic);
				$this -> classUserArray -> add($this -> classUser);
			
			$this -> CloseDataBase();

			return $this -> classUserArray;
		}
	}
// kopia
	public function loadUsers() {

		if ($this -> OpenDataBase()) {
			$selectSql = "SELECT `Username`, `Password`, `ProfilePic` FROM `User`";
			$stmt = $this -> GetDataBase() -> prepare($selectSql);
			$stmt -> execute();
			$stmt -> store_result();
			$stmt -> bind_result($userName, $password, $profilePic);

			$this -> classUserArray = new \user\UserArray();

			while ($stmt -> fetch()) {
				$this -> classUser = new \user\User($userName, $password, $profilePic);
				$this -> classUserArray -> add($this -> classUser);
			}
			$this -> CloseDataBase();

			return $this -> classUserArray;
		}
	}



	/**
	 * @param id int
	 * @return db_comment, string
	 * Hämtar en specifik kommentar
	 */
	public function getCommentValue($id) {

		if ($this -> OpenDataBase()) {

			$selectSql = 'SELECT `Comment` FROM `Post` WHERE `PostID` = ?';
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
	 * @param pic, Array
	 * @return pic[name], string
	 * Kontrollerar bildens filtyp och lägger den
	 * upp den på servern.
	 */
	public function savePostPic($pic, $loginUser) {

		$folderPath = "upload/" . $loginUser . "/post/";
	
		$this->createFolder($folderPath, $loginUser);
	
		$newPicName = $this->setPicName($folderPath, $pic);
		
		move_uploaded_file($pic["tmp_name"], $folderPath . $newPicName);

		return $newPicName;

	}



	public function saveProfilePic($pic, $loginUser) {

		$folderPath = "upload/" . $loginUser . "/profile/";

		$this->createFolder($folderPath, $loginUser);

		$newPicName = $this->setPicName($folderPath, $pic);
		
		move_uploaded_file($pic["tmp_name"], $folderPath . $newPicName);
		
		$imgPath = $folderPath . $newPicName;

		$dest_imagex = 50;

		$this -> makeThumbnail($imgPath, $pic['type'], $dest_imagex);

		return $newPicName;

	}	

	


	public function savePost($userName, $comment, $picName) {

		if ($this -> OpenDataBase()) {
			$insertSql = "INSERT INTO Post (Username, Comment, URL) VALUES (?,?,?)";
			$stmt = $this -> GetDataBase() -> prepare($insertSql);
			$stmt -> bind_param("sss", $userName, $comment, $picName);
			$stmt -> execute();
			$stmt -> store_result();
			$stmt -> fetch();

			$id = $stmt -> insert_id;

			return $id;

			$this -> CloseDataBase();
		}
	}

	/**
	 * @param id, int
	 * Tar bort posten. Kontrollerar ifall den inloggade och
	 * den som lade upp posten är den samma.
	 * Admin kan ta bort alla poster
	 */
	public function deletePost($id) {

		$sessUserName = $this -> classLoginModel -> GetSessionUserName();
		if ($this -> OpenDataBase()) {
			if ($sessUserName == self::$admin) {
				$selectSql = "DELETE FROM `Post` WHERE `PostID` = ?;";
			} else {
				$selectSql = "DELETE FROM `Post` WHERE `PostID` = ? AND `Username` = ?;";
			}
			$stmt = $this -> GetDataBase() -> prepare($selectSql);
			if ($sessUserName == self::$admin) {
				$stmt -> bind_param('i', $id);
			} else {
				$stmt -> bind_param('is', $id, $sessUserName);
			}
			$stmt -> execute();

			$this -> CloseDataBase();
		}
	}

	/**
	 * @param comment, string
	 * @param id, int
	 * Uppdaterar posten. Kontrollerar ifall den inloggade och
	 * den som lade upp posten är den samma.
	 * Admin kan uppdatera alla poster.
	 */
	public function updatePost($comment, $id, $loginUser) {

		if ($this -> OpenDataBase()) {

			if ($loginUser == self::$admin) {
				$selectSql = "UPDATE Post SET `Comment`= ? WHERE `PostID`= ?";
			} else {
				$selectSql = "UPDATE Post SET `Comment`= ? WHERE `PostID`= ? AND `Username` = ?";
			}
			$stmt = $this -> GetDataBase() -> prepare($selectSql);

			if ($loginUser == self::$admin) {
				$stmt -> bind_param('si', $comment, $id);
			} else {
				$stmt -> bind_param('sis', $comment, $id, $loginUser);
			}
			$stmt -> execute();

			$this -> CloseDataBase();
		}
	}

	public function changeProfilePicture($loginUser, $profilePicName) {

		if ($this -> OpenDataBase()) {
			$selectSql = "UPDATE `user` SET `ProfilePic`= ? WHERE `Username` = ?";
			$stmt = $this -> GetDataBase() -> prepare($selectSql);
			$stmt -> bind_param('ss', $profilePicName, $loginUser);
			$stmt -> execute();
			$this -> CloseDataBase();
		}
	}
	
	public function deleteUser($userName){
		
		if ($this -> OpenDataBase()) {
			$selectSql = "DELETE FROM user WHERE `Username` = ?";
			$stmt = $this -> GetDataBase() -> prepare($selectSql);
			$stmt -> bind_param('s', $userName);
			$stmt -> execute();
			
			$selectSql = "DELETE FROM post WHERE `Username` = ?";
			$stmt = $this -> GetDataBase() -> prepare($selectSql);
			$stmt -> bind_param('s', $userName);
			$stmt -> execute();
			
			$selectSql = "DELETE FROM gallery WHERE `Username` = ?";
			$stmt = $this -> GetDataBase() -> prepare($selectSql);
			$stmt -> bind_param('s', $userName);
			$stmt -> execute();
			
			$selectSql = "DELETE FROM gallerycomment WHERE `Username` = ?";
			$stmt = $this -> GetDataBase() -> prepare($selectSql);
			$stmt -> bind_param('s', $userName);
			$stmt -> execute();
			
			$this -> CloseDataBase();
		}
	}
}
