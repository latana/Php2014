<?php

namespace connectDB;

class ConnectDB {

	private $connectDB;

	public function openDataBase() {

		$this -> connectDB = new \mysqli("127.0.0.1", "root", "", "myface", 3306);

		if ($this -> connectDB -> connect_errno > 0) {
			return false;
		}
		return true;
	}

	public function closeDataBase() {

		$this -> connectDB -> close();
	}

	public function getDataBase() {

		return $this -> connectDB;
	}
}
