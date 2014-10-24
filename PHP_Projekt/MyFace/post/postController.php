<?php

namespace postController;

require_once 'model/postModel.php';
require_once 'post/postView.php';
require_once 'model/galleryCommentModel.php';

class PostController {

	/**
	 * @var object
	 */
	private $classPostView;

	/**
	 * @var object
	 */
	private $classPostModel;

	/**
	 * @var object
	 */	
	private $classFrontPageView;

	/**
	 * @var object
	 */	
	private $classGalleryCommentModel;

	public function __construct(\frontPageView\FrontPageView $classFrontPageView) {

		$this -> classPostView = new \postView\PostView($classFrontPageView);
		$this -> classPostModel = new \postModel\PostModel();
		$this->classGalleryCommentModel = new \galleryCommentModel\GalleryCommentModel();
		$this->classFrontPageView = $classFrontPageView;
	}

	/**
	 * @param loginUser string
	 * chekc if user wants to edit and delete
	 */
	public function postController($loginUser) {
		
		if ($this -> classPostView -> triedToEditPost()) {

			if($this->checkEditPost()){
				if($this -> classPostModel -> updatePost(trim($this -> classPostView -> getEditComment()),
															$this -> classPostView -> getEditButton(), $loginUser)){			
					$this -> classFrontPageView -> setMessage(\frontPageView\FrontPageView::EDIT_POST_SUCCESS);
				}
			}
		}
		if ($this -> classPostView -> triedToDeletePost()) {
			if($this -> classPostModel -> deletePost($this -> classPostView -> getPostID(), $loginUser)){
				$this -> classFrontPageView -> setMessage(\frontPageView\FrontPageView::DELETE_POST_SUCCESS);
			}
		}
	}
	
	/**
	 * @param loginUser string
	 * handels the comments on every picture
	 */
	public function commentController($loginUser) {

		if ($this -> classPostView -> triedToEditPost()) {
			if($this->checkEditPost()){
				if($this -> classGalleryCommentModel -> updateComment(trim($this -> classPostView -> getEditComment()),
															$this -> classPostView -> getEditButton(), $loginUser)){
					$this -> classFrontPageView -> setMessage(\frontPageView\FrontPageView::EDIT_COMMENT_SUCCESS);
				}
			}
		}
		if ($this -> classPostView -> triedToDeletePost()) {
			if($this -> classGalleryCommentModel -> deleteComment($this -> classPostView -> getPostID(), $loginUser)){
				$this -> classFrontPageView -> setMessage(\frontPageView\FrontPageView::DELETE_COMMENT_SUCCESS);
			}
		}
	}

	/**
	 * @return bool
	 * validates the new input
	 */
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