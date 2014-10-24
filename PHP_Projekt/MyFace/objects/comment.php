<?php

namespace comment;

	class CommentArray {

		/**
		 * @var Array
		 */
		private $m_commentArray = array();

		public function add (Comment $comment){
			array_push($this->m_commentArray, $comment);
		}
		/**
		 * @return Array
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
		 * @return int
		 */
		public function getID() {
			return $this -> m_galleryCommentID;
		}
		
		/**
		 * @return string
		 */
		public function getGalleryID(){
			return $this-> m_galleryID;
		}

		/**
		 * @return string
		 */
		public function getUserName() {
			return $this -> m_Username;
		}

		/**
		 * @return string
		 */
		public function getcomment() {
			return $this -> m_galleryComment;
		}
	}