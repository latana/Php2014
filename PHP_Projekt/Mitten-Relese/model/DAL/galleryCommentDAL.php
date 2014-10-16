<?php

namespace galleryCommentDAL;

require_once 'objects/comment.php';

class GalleryCommentDAL extends \connectDB\ConnectDB {

	private $classCommentArray;

	private $classComment;

	public function __construct() {

		$this -> classCommentArray = new \comment\CommentArray();
	}
  
  	public function saveGalleryComment($loginUser, $picID, $picComment) {

		if ($this -> OpenDataBase()) {
			$insertSql = "INSERT INTO Gallerycomment (GalleryID, Username, GalleryComment) VALUES (?,?,?)";
			$stmt = $this -> GetDataBase() -> prepare($insertSql);
			$stmt -> bind_param("sss", $picID, $loginUser, $picComment);
			$stmt -> execute();
			$stmt -> store_result();
			$stmt -> fetch();

			$id = $stmt -> insert_id;

			return $id;

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
	public function updateComment($comment, $id, $loginUser) {

		if ($this -> OpenDataBase()) {
			$selectSql = "UPDATE gallerycomment SET `GalleryComment`= ? WHERE `GalleryCommentID`= ?";
			$stmt = $this -> GetDataBase() -> prepare($selectSql);
			$stmt -> bind_param('si', $comment, $id);
			$stmt -> execute();
			$this -> CloseDataBase();
		}
	}

	/**
	 * @param id, int
	 * Tar bort posten. Kontrollerar ifall den inloggade och
	 * den som lade upp posten är den samma.
	 * Admin kan ta bort alla poster
	 */
	public function deleteComment($id) {

		if ($this -> OpenDataBase()) {
			$selectSql = "DELETE FROM `gallerycomment` WHERE `GalleryCommentID` = ?";
			$stmt = $this -> GetDataBase() -> prepare($selectSql);
			$stmt -> bind_param('i', $id);
			$stmt -> execute();
			$this -> CloseDataBase();
		}
	}
}