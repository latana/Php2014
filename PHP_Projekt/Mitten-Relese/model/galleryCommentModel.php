<?php
namespace galleryCommentModel;

require_once 'DAL/galleryCommentDAL.php';

class GalleryCommentModel {

	private $galleryCommentDAL;

	public function __construct() {

		$this -> galleryCommentDAL = new \galleryCommentDAL\GalleryCommentDAL();
	}

	public function updateComment($newComment, $postID, $userName) {

		$this -> galleryCommentDAL -> updateComment($newComment, $postID, $userName);
	}

	public function deleteComment($postID) {

		$this -> galleryCommentDAL -> deleteComment($postID);
	}

	public function saveGalleryComment($loginUser, $picID, $picComment) {

		$this -> galleryCommentDAL -> saveGalleryComment($loginUser, $picID, $picComment);
	}

}
