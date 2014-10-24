<?php

namespace user;

	class UserArray {

		/**
		 * @var Array
		 */
		private $m_userArray = array();

		public function __construct() {
		}

		public function add (User $user){
			array_push($this->m_userArray, $user);
		}
		/**
		 * @return Array
		 */
		public function get(){
			return $this->m_userArray;
		}
	}

    class User {

		/**
		 * @var string
		 */
		private $m_userName;

		/**
		 * @var string
		 */
		private $m_password;

		/**
		 * @var string
		 */
		private $m_profilePic;


		public function __construct($userName, $password, $profilePic) {
			$this -> m_userName = $userName;
			$this -> m_password = $password;
			$this -> m_profilePic = $profilePic;
		}

		/**
		 * @return string
		 */
		public function getUserName() {
			return $this -> m_userName;
		}

		/**
		 * @return string
		 */
		public function getPassword() {
			return $this -> $m_password;
		}

		/**
		 * @return string
		 */
		public function getProfilePic() {
			return $this -> m_profilePic;
		}
	}