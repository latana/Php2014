<?php

namespace postView;

class postView{

	/**
	 * @var string
	 */
	private $editMenuButton = "editmenubutton";

	/**
	 * @var string
	 */
	private $edit = "edit";

	/**
	 * @var string
	 */
	private $delete = "delete";

	/**
	 * @var string
	 */
	private static $postClassName = "postClass";

	/**
	 * @var string
	 */
	private static $editForm = "editForm";

	/**
	 * @var string
	 */
	private $allPosts;

	/**
	 * @var string
	 */	
	private $classFrontPageView;

	/**
	 * @var string
	 */	
	private static $admin;

	/**
	 * @var string
	 */	
	private static $userGallery;

	/**
	 * @var string
	 */	
	private static $uploadPath;

	/**
	 * @var string
	 */	
	private static $profilePath;

	/**
	 * @var string
	 */	
	private static $postPath;
	
	public function __construct(){
		
		self::$admin = \settings\Settings::$admin;
		
		self::$userGallery = \settings\Settings::$userGallery; 
		self::$uploadPath = \settings\Settings::$uploadPath;
		self::$profilePath = \settings\Settings::$profilePath;
		self::$postPath = \settings\Settings::$postPath;
	}
	
	/**
	 * @return bool
	 * return true if the user pressed the edit button in the edit menu
	 */
	public function triedToEditPost() {

		if (isset($_POST[$this -> editMenuButton])) {
			return true;
		}
		return false;
	}

	/**
	 * @return bool
	 * return true if the user have pressed the edit button
	 */
	public function wantToEditPost() {
			
		if (isset($_POST[$this -> edit])) {
			return true;
		}
		return false;
	}

	/**
	 * @return string
	 * return the id of the selected post
	 */
	public function getEditButton() {

		if (isset($_POST[$this -> editMenuButton])) {
			return $_POST[$this -> editMenuButton];
		}
	}

	/**
	 * @return string
	 * return the new comment
	 */
	public function getEditComment() {

		if (isset($_POST[self::$editForm])) {
			return ($_POST[self::$editForm]);
		}
	}

	/**
	 * @return bool
	 * return true if the user pressed the delete button
	 */
	public function triedToDeletePost() {
		if (isset($_POST[$this -> delete])) {
			return true;
		}
		return false;
	}

	/**
	 * @return string
	 * return the id of the activ post
	 */
	public function getPostID() {

		if (isset($_POST[$this -> delete])) {
			return $_POST[$this -> delete];
		}
		if (isset($_POST[$this -> edit])) {
			return $_POST[$this -> edit];
		}
	}
	
	/**
	 * @param postID integer
	 * @return string
	 * returns the editbutton
	 */
	public function doEditButton($postID) {
		$editButton = "<div class = 'divedit'>
							<form method='POST'>
								<input type='hidden' value='" . $postID . "' name='" . $this -> edit . "' />
								<input class='editButton' type='submit' value='Edit' />
							</form>
					   </div>";
		return $editButton;
	}
	
	/**
	 * @param postID integer
	 * @return string
	 * returns the deletebutton
	 */
	public function doDeleteButton($postID) {
		$deleteButton = "<div class = 'divdelete'>
							<form method='POST'>
								<input type='hidden' value='" . $postID . "' name='" . $this -> delete . "' />
								<input class='deleteButton' type='submit' value='Delete' />
							</form>
						</div>";
		return $deleteButton;
	}

	/**
	 * @param comment string
	 * @param postID integer
	 * @return string
	 * returns the edit menu
	 */
	public function editMenu($comment, $postID) {

		return "<div id ='gray'></div>
				<div class = 'editmenu'>
					<div class ='xbuttonDiv'>
						<form method='post' enctype='multipart/form-data'>
							<input class='thesmalXbutton'type='submit' value='X' />
						</form>
					</div>
					<div class='edittestform'>
						<form method='post' enctype='multipart/form-data'>
							<textarea class = 'posttextarea' name='" . self::$editForm . "' rows='6' cols='40'>" . $comment . "</textarea>
							<div class ='editPostDiv'>
								<input type='hidden' value='" . $postID . "' name='" . $this -> editMenuButton . "' />
								<input class='editPostButton' type='submit' value='Edit' />
							</div>
						</form>
					</div>
				</form>";
	}

	/**
	 * @param loginUser string
	 * @return string
	 * creates and returns all the posts
	 */
	public function showPost(\post\PostArray $postArray, \user\UserArray $userArray, $loginUser) {

	$divName = 'loadpostclass';

		foreach ($postArray->get() as $post) {

			$this -> allPosts .= $this -> ShowUser($post, $userArray, $divName);
			$this -> allPosts .= $this -> EditOrComment($post);
			$this -> allPosts .= $this -> ShowPic($post, $loginUser);
			$this -> allPosts .= $this -> ButtontForUser($loginUser, $post);
			$this -> allPosts .= "</div>";
		}
		return $this -> allPosts;
	}
	
	/**
	 * @param loginUser string
	 * @return string
	 * creates and returns all the comments
	 */
	public function showComment(\comment\CommentArray $commentArray, \user\UserArray $userArray, $loginUser) {
			
		$divName = 'loadGalleryClass';

		foreach ($commentArray->get() as $comment) {

			$this -> allPosts .= $this -> ShowUser($comment, $userArray, $divName);
			$this -> allPosts .= $this -> EditOrComment($comment);
			$this -> allPosts .= $this -> ButtontForUser($loginUser, $comment);
			$this -> allPosts .= "</div></div>";
		}
		return $this -> allPosts;
	}

	/**
	 * @param obj object
	 * @param userArray object
	 * @param divname string
	 * render out the user with the correct post
	 */
	private function showUser($obj, $userArray, $divName) {
		
		foreach ($userArray->get() as $user) {

			if ($user -> getUserName() == $obj -> getUsername()) {

				$this -> allPosts .=
						"<div class = '".$divName."'>
						<div class='userDiv'>
							<div class = 'divprofilepic'>
								<a class='AuserLink' href='?".self::$userGallery."=".$user->getUserName()."'>
									<img class = 'postpic' src='".self::$uploadPath."/" . $obj -> getUsername() .
												"/".self::$profilePath."/" .$user -> getProfilePic() . "' alt = 'pic'>
								</a>
							</div>
						<div class='userNameDiv'>
								<a class='AuserLink' href='?".self::$userGallery."=".$user->getUserName()."'>" . $user->getUserName()."</a> 
							</div></div>";
				break;
			}
		}
	}

	/**
	 * @param obj object
	 * render edit menu or normal post
	 */
	private function editOrComment($obj) {

		if ($this -> wantToEditPost() && $this -> getPostID() == $obj -> getID()) {
			$this -> allPosts .= $this -> EditMenu($obj -> getcomment(), $obj -> getID());
		}
		else {
			$this -> allPosts .=
			"<div class='commentAndPic'> 
				<div class = 'commentClass'>
					<p class = '" . self::$postClassName . "'>" . $obj -> getcomment() . "</p>
				</div>";
		}
	}

	/**
	 * @param obj object
	 * handels the picture
	 */
	private function showPic($obj) {

		if ($obj -> getpostPic() == null) {
			$this -> allPosts .= "</div>";
		}
		else if($this -> wantToEditPost() && $this -> getPostID() == $obj -> getID()){
			$this->allPosts .="</div>";
		}
		else {
			$this -> allPosts .= 
				"<div class = 'divpostpic'>
					<img class = 'postpic' src='".self::$uploadPath."/" . $obj -> getUsername() .
											"/".self::$postPath."/" . $obj -> getpostPic() . "' alt = 'pic''>
				</div>
			</div>";
		}
	}
	
	/**
	 * @param loginUser string
	 * @param obj object
	 * render buttons if the user created the post or it is admin
	 */
	private function buttontForUser($loginUser, $obj) {

		if ($this -> wantToEditPost() && $this -> getPostID() == $obj -> getID()) {
			return;
		}
		else if ($loginUser == self::$admin) {

			$this -> allPosts .= $this -> doEditButton($obj -> getID()) . $this -> doDeleteButton($obj -> getID());
		}
		else if ($obj -> getUsername() == $loginUser) {

			$this -> allPosts .= $this -> doEditButton($obj -> getID()) . $this -> doDeleteButton($obj -> getID());
		}
	}
}