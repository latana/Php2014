<?php

namespace post;

	class PostArray {

		/**
		 * @var Array
		 */
		private $m_postArray = array();

		public function add (Post $post){
			array_push($this->m_postArray, $post);
		}
		/**
		 * @return Array
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
		 * @return int
		 */
		public function getID() {
			return $this -> m_postID;
		}

		/**
		 * @return string
		 */
		public function getUserName() {
			return $this -> m_postUserName;
		}

		/**
		 * @return string
		 */
		public function getcomment() {
			return $this -> m_comment;
		}

		/**
		 * @return string
		 */
		public function getpostPic(){
			return $this-> m_postPic;
		}
	}