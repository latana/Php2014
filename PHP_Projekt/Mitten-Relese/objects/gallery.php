<?php

namespace gallery;

	class GalleryArray {

		/**
		 * @var Array
		 */
		private $m_galleryArray = array();

		public function __construct() {
		}

		public function add (Gallery $gallery){
			array_push($this->m_galleryArray, $gallery);
		}
		/**
		 * @return m_postArray, Array
		 */
		public function get(){
			return $this->m_galleryArray;
		}
	}

    class Gallery {

		/**
		 * @var int
		 */
		private $m_galleryID;

		/**
		 * @var string
		 */
		private $m_galleryUserName;

		/**
		 * @var string
		 */
		private $m_galleryPicName;

		/**
		 * @var string
		 */
		private $m_galleryURL;
		
		/**
		 * @var string
		 */
		private $m_galleryPicComment;


		public function __construct($galleryID, $galleryUserName, $galleryPicName, $galleryURL, $galleryPicComment) {
			$this -> m_galleryID = $galleryID;
			$this -> m_galleryUserName = $galleryUserName;
			$this -> m_galleryPicName = $galleryPicName;
			$this -> m_galleryURL = $galleryURL;
			$this -> m_galleryPicComment = $galleryPicComment;
		}

		/**
		 * @return m_postID, int
		 */
		public function getgalleryID() {
			return $this -> m_galleryID;
		}

		/**
		 * @return m_postUserName, string
		 */
		public function getgalleryUserName() {
			return $this -> m_galleryUserName;
		}

		/**
		 * @return m_comment, string
		 */
		public function getgalleryPicName() {
			return $this -> m_galleryPicName;
		}

		/**
		 * @return m_postPic, string
		 */
		public function getgalleryURL(){
			return $this-> m_galleryURL;
		}
		
		/**
		 * @return m_postProfilepic, string
		 */
		public function getgalleryPicComment(){
			return $this-> m_galleryPicComment;
		}
	}