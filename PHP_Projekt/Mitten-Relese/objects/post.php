<?php

namespace post;

	class PostArray {

		/**
		 * @var Array
		 */
		private $m_postArray = array();

		public function __construct() {
		}

		public function add (Post $post){
			array_push($this->m_postArray, $post);
		}
		/**
		 * @return m_postArray, Array
		 */
		public function get(){
			return $this->m_postArray;
		}
	}

    class Post {

		/**
		 * @var int
		 */
		private $m_postID;

		/**
		 * @var string
		 */
		private $m_postUserName;

		/**
		 * @var string
		 */
		private $m_comment;

		/**
		 * @var string
		 */
		private $m_postPic;


		public function __construct($postID, $postUserName, $comment, $postPic) {
			$this -> m_postID = $postID;
			$this -> m_postUserName = $postUserName;
			$this -> m_comment = $comment;
			$this-> m_postPic = $postPic;
		}

		/**
		 * @return m_postID, int
		 */
		public function getpostID() {
			return $this -> m_postID;
		}

		/**
		 * @return m_postUserName, string
		 */
		public function getpostUserName() {
			return $this -> m_postUserName;
		}

		/**
		 * @return m_comment, string
		 */
		public function getcomment() {
			return $this -> m_comment;
		}

		/**
		 * @return m_postPic, string
		 */
		public function getpostPic(){
			return $this-> m_postPic;
		}
	}