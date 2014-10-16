<?php

namespace navigaterView;

class NavigaterView{
	
	private static $logoutButton = "logoutButton";

	private static $userPage = "userpage";

	private static $userGallery = "usergallery";

	private static $frontPage = "frontPage";
	
	private static $memberPage = "memberPage";
	
	private $url = 'http://';
	
	public static function tryToLogout() {

		if (isset($_POST[self::$logoutButton])) {
			return true;
		}
		return false;
	}
	
	public function justLoggedIn() {
		
		$this->url .= $_SERVER['REQUEST_URI'];

		if (strpos($this->url,\loginView\LoginView::$login) == true) {
			return true;
		}
		return false;
	}

	public static function tryToUserPage() {

		if (isset($_GET[self::$userPage])) {
			return true;
		}
		return false;
	}

	public static function tryToGalleryPage() {

		if (isset($_GET[self::$userGallery])) {
			return true;
		}
		return false;
	}

	public static function tryToFrontPage() {

		if (isset($_GET[self::$frontPage])) {
			return true;
		}
		return false;
	}
	
	public static function tryToMemberPage(){
			
		if(isset($_GET[self::$memberPage])){
			return true;
		}
		return false;
	}
	
	public function navigationButtons($loginUser) {

		return "<div class = 'divlogout'>
			<form class = 'logoutform' action='?logout' method='post' enctype='multipart/form-data'>
			<input class = 'logoutbutton' type='submit' name='" . self::$logoutButton . "'  value='Log out' />
			</form></div>
			<div class = 'navigationbuttons'>
			<a class = 'navigationlink' href='?" . self::$frontPage . "'>Home</a>
			<a class = 'navigationlink' href='?" . self::$memberPage . "'>Members</a>
			<a class = 'navigationlink' href='?" . self::$userPage ."'>" . $loginUser . "</a>
			<a class = 'navigationlink' href='?" . self::$userGallery ."&" .$loginUser. " '>Gallery</a>
			</div>";
	}
}