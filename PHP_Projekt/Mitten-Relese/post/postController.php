<?php

namespace postController;

require_once 'model/postModel.php';
require_once 'post/postView.php';
require_once 'model/galleryCommentModel.php';

class PostController {

	private $classPostView;

	private $classPostModel;
	
	private $classFrontPageView;
	
	private $classGalleryCommentModel;

	public function __construct(\frontPageView\FrontPageView $classFrontPageView) {

		$this -> classPostView = new \postView\PostView($classFrontPageView);
		$this -> classPostModel = new \postModel\PostModel();
		$this->classGalleryCommentModel = new \galleryCommentModel\GalleryCommentModel();
		$this->classFrontPageView = $classFrontPageView;
	}

	public function postController($loginUser) {

		if ($this -> classPostView -> triedToEditPost()) {

			if($this->checkEditPost()){
				$this -> classPostModel -> updatePost(trim($this -> classPostView -> getEditComment()),
															$this -> classPostView -> getEditButton(), $loginUser);
			}
		}
		if ($this -> classPostView -> triedToDeletePost()) {
			$this -> classPostModel -> deletePost($this -> classPostView -> getPostID());
		}
	}
	
	public function commentController($loginUser) {

		if ($this -> classPostView -> triedToEditPost()) {
			if($this->checkEditPost()){
				$this -> classGalleryCommentModel -> updateComment(trim($this -> classPostView -> getEditComment()),
															$this -> classPostView -> getEditButton(), $loginUser);
			}
		}
		if ($this -> classPostView -> triedToDeletePost()) {
			$this -> classGalleryCommentModel -> deleteComment($this -> classPostView -> getPostID());
		}
	}

	public function checkEditPost() {

		if ($this -> classPostView -> getEditComment() == null) {
			$this -> classFrontPageView -> setMessage(\frontPageView\FrontPageView::EMPTY_EDIT_COMMENT);
			return false;
		}
		if (strip_tags($this -> classPostView -> getEditComment()) !== $this -> classPostView -> getEditComment()) {
			$this -> classFrontPageView -> setMessage(\frontPageView\FrontPageView::STRIP_TAGS_COMMENT);
			return false;
		}
		return true;
	}
}