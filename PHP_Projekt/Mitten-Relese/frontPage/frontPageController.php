<?php
   	
namespace frontPageController;   	
   	
require_once 'frontPage/frontPageView.php';
require_once 'userPage/userPageView.php';
require_once 'model/postModel.php';
require_once 'post/postController.php';
require_once 'galleryPage/galleryPageController.php';
require_once 'userPage/userPageController.php';
	
   	class FrontPageController{
   		
		private $classFrontPageView;
		
		private $classPostModel;
		
		private $admin;
		
		private $classPostController;
   		
		public function __construct(\frontPageView\FrontPageView $classFrontPageView) {

			$this->classFrontPageView = $classFrontPageView;
			$this->classPostModel = new \postModel\PostModel();
			$this->classLoginModel = new\loginModel\LoginModel();
			$this->admin = $this->classLoginModel->getAdmin();
			$this->classPostController = new \postController\PostController($this->classFrontPageView);
		}
		
		public function frontPage($loginUser){
			
			if($this->classFrontPageView->triedToPost()){
				$this->frontPagePost($loginUser);
			}
			$this->classPostController->postController($loginUser);
			
			$this->classFrontPageView->showFrontPage($loginUser, $this->admin);
		}
		
		private function frontPagePost($loginUser){

			if($this->classFrontPageView->getComment() == null){
				$this->classFrontPageView->setMessage(\frontPageView\FrontPageView::EMPTY_COMMENT);
				return false;
			}
			if($this->classFrontPageView->getComment() !== strip_tags($this->classFrontPageView->getComment())){
				$this->classFrontPageView->setMessage(\frontPageView\FrontPageView::STRIP_TAGS_COMMENT);
				return false;	
			}
			else{ // här ska du fixa så att man inte laddar upp skadliga koder i bilderna
				if($this->classPostModel->validatePic($this->classFrontPageView->getPic())){
					$picName = $this->classPostModel->savePostPic($this->classFrontPageView->getPic(), $loginUser);
					$this->classPostModel->savePost($loginUser, $this->classFrontPageView->getComment(), $picName);
				}
				else if($this->classFrontPageView->getPic() == null){
					$this->classPostModel->savePost($loginUser, $this->classFrontPageView->getComment(),
																$this->classFrontPageView->getPic());
				}
			}
		}
   	}