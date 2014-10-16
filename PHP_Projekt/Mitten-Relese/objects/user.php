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
		 * @return m_userArray, Array
		 */
		public function get(){
			return $this->m_userArray;
		}
	}

    class User {

		/**
		 * @var int
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
		 * @return m_userName, int
		 */
		public function getUserName() {
			return $this -> m_userName;
		}

		/**
		 * @return $m_password, string
		 */
		public function getPassword() {
			return $this -> $m_password;
		}

		/**
		 * @return $m_profilePic, string
		 */
		public function getProfilePic() {
			return $this -> m_profilePic;
		}
	}