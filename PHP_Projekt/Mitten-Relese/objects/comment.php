<?php

namespace comment;

	class CommentArray {

		/**
		 * @var Array
		 */
		private $m_commentArray = array();

		public function __construct() {
		}

		public function add (Comment $comment){
			array_push($this->m_commentArray, $comment);
		}
		/**
		 * @return m_commentArray, Array
		 */
		public function get(){
			return $this->m_commentArray;
		}
	}

    class Comment {

		/**
		 * @var int
		 */
		private $m_galleryCommentID;

		/**
		 * @var string
		 */
		private $m_galleryID;

		/**
		 * @var string
		 */
		private $m_Username;

		/**
		 * @var string
		 */
		private $m_galleryComment;


		public function __construct($galleryCommentID, $galleryID, $Username, $galleryComment) {
			$this -> m_galleryCommentID = $galleryCommentID;
			$this -> m_galleryID = $galleryID;
			$this -> m_Username = $Username;
			$this -> m_galleryComment = $galleryComment;
		}

		/**
		 * @return m_galleryCommentID, int
		 */
		public function getpostID() {
			return $this -> m_galleryCommentID;
		}
		
		/**
		 * @return m_galleryID, string
		 */
		public function getGalleryID(){
			return $this-> m_galleryID;
		}

		/**
		 * @return m_Username, string
		 */
		public function getpostUserName() {
			return $this -> m_Username;
		}

		/**
		 * @return m_galleryComment, string
		 */
		public function getcomment() {
			return $this -> m_galleryComment;
		}
	}