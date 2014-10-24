<?php

namespace navigaterController;

require_once 'frontPage/frontPageController.php';
require_once 'userPage/userPageController.php';
require_once 'galleryPage/galleryPageController.php';
require_once 'memberPage/memberPageController.php';
require_once 'errorView.php';
require_once 'frontPage/frontPageView.php';
require_once 'navigater/navigaterView.php';

class NavigaterController {

	/**
	 * @var object
	 */
	private $classNavigaterView;
	
	/**
	 * @var object
	 */
	private $classFrontPageView;

	public function __construct() {

		$this -> classNavigaterView = new \navigaterView\NavigaterView();
		$this -> classFrontPageView = new \frontPageView\FrontPageView();
	}

	/**
	 * @return bool
	 * return true if the user have pressed the logout button
	 */
	public function userWantToLogout() {

		if ($this -> classNavigaterView -> tryToLogout()) {
			return true;
		}
	}

	/**
	 * @param loginUser
	 * creats an object depending on what button the user
	 * have pressed
	 */
	public function checkNavButtons($loginUser) {
	
		try{	
			if ($this -> classNavigaterView -> tryToUserPage()) {
				new \userPageController\UserPageController($this -> classFrontPageView, $loginUser);
			}
			else if($this->classNavigaterView->tryToMemberPage()){
				new \memberPageController\MemberPageController($this->classFrontPageView, $loginUser);
			}
			else if ($this -> classNavigaterView -> tryToGalleryPage()) {
				new \galleryPageController\GalleryPageController($this -> classFrontPageView, $loginUser);
			}
			else if ($this -> classNavigaterView -> tryToFrontPage() || $this->classNavigaterView->justLoggedIn()) {
				new \frontPageController\FrontPageController($this -> classFrontPageView, $loginUser);
			}
			else{
				new \errorView\ErrorView();
			}
		}
		catch(\Exception $e) {
			new \errorView\ErrorView();
		}
	}
}