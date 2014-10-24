<?php

namespace navigaterView;

require_once 'settings.php';

class NavigaterView{
	
	/**
	 * @var string
	 */
	private static $logoutButton = "logoutButton";

	/**
	 * @var string
	 */
	private static $userPage;
	
	/**
	 * @var string
	 */
	private static $userGallery;
	
	/**
	 * @var string
	 */
	private static $frontPage;
	
	/**
	 * @var string
	 */	
	private static $memberPage;
	
	/**
	 * @var string
	 */	
	private $url = 'http://';
	
	/**
	 * @var string
	 */	
	private static $indexPath;
	
	/**
	 * @var string
	 */	
	private static $login;
	
	/**
	 * @var string
	 */	
	private static $REQUEST_URI;
	
	/**
	 * @var string
	 */	
	private static $root;
	
	public function __construct(){
		
		self::$userPage = \settings\Settings::$userPage;
		self::$userGallery = \settings\Settings::$userGallery;
		self::$frontPage = \settings\Settings::$frontPage;
		self::$memberPage = \settings\Settings::$memberPage;
		self::$indexPath = \settings\Settings::$indexPath;
		self::$login = \settings\Settings::$login;
		self::$REQUEST_URI = \settings\Settings::$REQUEST_URI;
		self::$root = \settings\Settings::$root;
	}
	
	/**
	 * @return bool
	 * return true if the user pressed the logout button
	 */
	public static function tryToLogout() {

		if (isset($_POST[self::$logoutButton])) {
			return true;
		}
		return false;
	}
	
	/**
	 * @return bool
	 * return true if the url contain ?login or index.php
	 */
	public function justLoggedIn() {
		
		$this->url .= $_SERVER[self::$REQUEST_URI];

		if (strpos($this->url,self::$login) == true) {
			return true;
		}
		else if(strpos($this->url,self::$indexPath) == true){
			return true;
		}
		else if($this->url == self::$root){
			return true;
		}
		
		return false;
	}

	/**
	 * @return bool
	 * return true if the user pressed the user link
	 */
	public static function tryToUserPage() {

		if (isset($_GET[self::$userPage])) {
			return true;
		}
		return false;
	}

	/**
	 * @return bool
	 * return true if the user pressed the gallery link
	 */
	public static function tryToGalleryPage() {

		if (isset($_GET[self::$userGallery])) {
			return true;
		}
		return false;
	}

	/**
	 * @return bool
	 * return true if the user pressed the frontpage link
	 */
	public static function tryToFrontPage() {

		if (isset($_GET[self::$frontPage])) {
			return true;
		}
		return false;
	}
	
	/**
	 * @return bool
	 * return true if the user pressed the members link
	 */
	public static function tryToMemberPage(){
			
		if(isset($_GET[self::$memberPage])){
			return true;
		}
		return false;
	}
	
	/**
	 * @paran loginUser string
	 * @return string
	 * returns the navigationbuttons
	 */
	public function navigationButtons($loginUser) {

		return "<div class = 'divlogout'>
					<form class = 'logoutform' action='?logout' method='post' enctype='multipart/form-data'>
					<input class = 'logoutbutton' type='submit' name='" . self::$logoutButton . "'  value='Log out' />
					</form>
				</div>
				<div class = 'navigationbuttons'>
					<ul>
						<li>
							<a class = 'navigationlink' href='?" . self::$frontPage . "'>Home</a>
						</li>
					
						<li>
							<a class = 'navigationlink' href='?" . self::$memberPage . "'>Members</a>
						</li>
						<li class='userLink'>
							<a class = 'navigationlink' href='?" . self::$userPage ."'>" . $loginUser . "</a>
						</li>
						<li>
							<a class = 'navigationlink' href='?" . self::$userGallery ."=" .$loginUser. " '>Gallery</a>
						</li>
					</ul>
				</div>";
	}
}