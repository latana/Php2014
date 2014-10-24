<?php
   	
namespace frontPageController;   	

require_once 'model/postModel.php';
require_once 'post/postController.php';
require_once 'model/userModel.php';
	
   	class FrontPageController{
   		
		/**
		 * @var object
		 */
		private $classFrontPageView;
		
		/**
		 * @var object
		 */
		private $classPostModel;
		
		 
		 /**
		 * @var object
		 */
		private $classPostController;
		
		/**
		 * @var object
		 */
		private $classUserModel;
   		
		public function __construct(\frontPageView\FrontPageView $classFrontPageView, $loginUser) {

			$this->classFrontPageView = $classFrontPageView;
			$this->classPostModel = new \postModel\PostModel();
			$this->classUserModel = new \userModel\UserModel();
			$this->classPostController = new \postController\PostController($this->classFrontPageView);
			
			$this->frontPage($loginUser);
		}
		
		/**
		 * @param loginUser string
		 * Check if user want's to add,
		 * change or delete a post and show's frontPage
		 */
		public function frontPage($loginUser){
			
			if($this->classFrontPageView->triedToPost()){
				$this->frontPagePost($loginUser);
			}
			$this->classPostController->postController($loginUser);
			
			$postObj = $this -> classPostModel -> loadPost();
			$userObj = $this -> classUserModel -> loadUsers();
			
			$this->classFrontPageView->showFrontPage($postObj, $userObj, $loginUser);
		}
		
		/**
		 * @param loginUser string
		 * @return bool,
		 * check the user input in the post
		 * and check if there is a picture.
		 */
		private function frontPagePost($loginUser){

			if($this->classFrontPageView->getComment() == null){
				$this->classFrontPageView->setMessage(\frontPageView\FrontPageView::EMPTY_COMMENT);
				return false;
			}
			if($this->classFrontPageView->getComment() !== strip_tags($this->classFrontPageView->getComment())){
				$this->classFrontPageView->setMessage(\frontPageView\FrontPageView::STRIP_TAGS_COMMENT);
				return false;	
			}
			else{
				if($this->classPostModel->validatePic($this->classFrontPageView->getPic())){
					if($this->classPostModel->checkPicSize($this->classFrontPageView->getPic())){
						$picName = $this->classPostModel->savePostPic($this->classFrontPageView->getPic(), $loginUser);
						$this->classPostModel->savePost($loginUser, $this->classFrontPageView->getComment(), $picName);
						$this->classFrontPageView->reloadPage();
					}
					else{
						$this->classFrontPageView->setMessage(\frontPageView\FrontPageView::PIC_TO_BIG);
					}
				}
				else if($this->classFrontPageView->getPic() == null){
					$this->classPostModel->savePost($loginUser, $this->classFrontPageView->getComment(),
																$this->classFrontPageView->getPic());
					$this->classFrontPageView->reloadPage();
				}
				else{
					$this->classFrontPageView->setMessage(\frontPageView\FrontPageView::PIC_VALIDATION);
				}
			}
		}
   	}