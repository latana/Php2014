<?php

namespace pageNavigater;

require_once 'frontPage/frontPageController.php';
require_once 'userPage/userPageController.php';
require_once 'galleryPage/galleryPageController.php';
require_once 'frontPage/FrontPageView.php';
require_once 'memberPage/memberPageController.php';
require_once 'master/errorView.php';

class PageNavigater {

	private $classFrontPageController;
	private $classUserPageController;
	private $classGalleryPageController;
	private $classNavigaterView;
	private $classFrontPageView;
	private $classMemberController;

	public function __construct() {

		$this -> classNavigaterView = new \navigaterView\NavigaterView();
		$this -> classFrontPageView = new \frontPageView\FrontPageView();
		$this->classMemberController = new \memberPageController\MemberPageController($this->classFrontPageView);
		$this -> classFrontPageController = new \frontPageController\FrontPageController($this -> classFrontPageView);
		$this -> classUserPageController = new \userPageController\UserPageController($this -> classFrontPageView);
		$this -> classGalleryPageController = new \galleryPageController\GalleryPageController($this -> classFrontPageView);
		$this -> classGalleryView = $this -> classGalleryPageController -> getGalleryView();
	}

	public function userWantToLogout() {

		if ($this -> classNavigaterView -> tryToLogout()) {
			return true;
		}
	}

	public function checkNavButtons($loginUser) {
		
		if ($this -> classNavigaterView -> tryToUserPage()) {
			$this -> classUserPageController -> userPage($loginUser);
		}
		else if($this->classNavigaterView->tryToMemberPage()){
			$this->classMemberController->memberPage($loginUser);
		}
		else if ($this -> classNavigaterView -> tryToGalleryPage()) {
			$this -> classGalleryPageController -> galleryPage($loginUser);
		}
		else if ($this -> classNavigaterView -> tryToFrontPage() || $this->classNavigaterView->justLoggedIn()) {
			$this -> classFrontPageController -> frontPage($loginUser);
		}
		else {
			$this->classErrorView =  new \errorView\ErrorView();
		}
	}

}
