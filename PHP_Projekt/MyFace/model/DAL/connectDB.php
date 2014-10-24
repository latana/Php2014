<?php

namespace connectDB;

class ConnectDB {
	
	/**
	 * object
	 */
	private $connectDB;

	/**
	 * @return bool
	 */
	public function openDataBase() {

		$this->connectDB = new \mysqli("hemligt", "hemligt", "hemligt", "hemligt");

		if ($this -> connectDB -> connect_errno > 0) {
			return false;
		}
		return true;
	}


	public function closeDataBase() {

		$this -> connectDB -> close();
	}

	/**
	 * @return object
	 */
	public function getDataBase() {

		return $this -> connectDB;
	}
}
