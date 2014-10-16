<?php

namespace postView;

require_once 'model/DAL/postDAL.php';
require_once 'master/basicView.php';

class postView{

	/**
	 * @var string
	 */
	private $editMenuButton = "editmenubutton";

	private $edit = "edit";

	private $delete = "delete";

	private static $postClassName = "postClass";

	/**
	 * @var string
	 */
	private static $editForm = "editForm";

	private $allPosts;
	
	private $classFrontPageView;

	public function triedToEditPost() {

		if (isset($_POST[$this -> editMenuButton])) {

			return true;
		}
		return false;
	}

	/**
	 * @return bool, retunerar true om man trycker på edit knappen
	 */
	public function wantToEditPost() {
			
		if (isset($_POST[$this -> edit])) {
			return true;
		}
		return false;
		
	}

	/**
	 * @return string, retunerar edit-knappen
	 * när man är klar med sin uppdatering.
	 */
	public function getEditButton() {

		if (isset($_POST[$this -> editMenuButton])) {

			return $_POST[$this -> editMenuButton];
		}
	}

	public function getEditComment() {

		if (isset($_POST[self::$editForm])) {

			return ($_POST[self::$editForm]);
		}
	}

	public function triedToDeletePost() {
		if (isset($_POST[$this -> delete])) {

			return true;
		}
		return false;
	}

	/**
	 * @return string, retunerar id'et på posten
	 * i knapparna edit och delete
	 */
	public function getPostID() {

		if (isset($_POST[$this -> delete])) {
			return $_POST[$this -> delete];
		}
		if (isset($_POST[$this -> edit])) {
			return $_POST[$this -> edit];
		}
	}

	public function doEditButton($postID) {
		$editButton = "<div class = 'divedit'><form method='POST'>
			<input type='hidden' value='" . $postID . "' name='" . $this -> edit . "' />
			<input type='submit' value='Edit' /></form></div>";
		return $editButton;
	}

	public function doDeleteButton($postID) {
		$deleteButton = "<div class = 'divdelete'><form method='POST'>
			<input type='hidden' value='" . $postID . "' name='" . $this -> delete . "' />
			<input type='submit' value='Delete' /></form></div>";
		return $deleteButton;
	}

	public function editMenu($comment, $postID) {

		return "<div id ='gray'> <div id = 'editmenu'>
			<form method='post' enctype='multipart/form-data'>
			<textarea class = 'editform' type='text' name='" . self::$editForm . "' rows='4' cols='30'>" . $comment . "</textarea>
			<input type='hidden' value='" . $postID . "' name='" . $this -> editMenuButton . "' />
			<input type='submit' value='Edit Post' />
			</form>
			<form method='post' enctype='multipart/form-data'>
			<input type='submit' value='X' />
			</form>
			</div></div>";
	}

	public function showPost(\post\PostArray $postArray, \user\UserArray $userArray, $loginUser, $admin) {

		foreach ($postArray->get() as $post) {

			$this -> allPosts .= $this -> ShowUser($post, $userArray);
			$this -> allPosts .= $this -> EditOrComment($post);
			$this -> allPosts .= $this -> ShowPic($post, $loginUser);
			$this -> allPosts .= $this -> ButtontForUser($loginUser, $admin, $post);

		}
		return $this -> allPosts;
	}
	
	public function showComment(\comment\CommentArray $commentArray, \user\UserArray $userArray, $loginUser, $admin) {

		foreach ($commentArray->get() as $comment) {

			$this -> allPosts .= $this -> ShowUser($comment, $userArray);
			$this -> allPosts .= $this -> EditOrComment($comment);
			$this -> allPosts .= $this -> ButtontForUser($loginUser, $admin, $comment);

		}
		return $this -> allPosts;
	}

	private function showUser($post, $userArray) {
		//if(isset($userArray[$post->getPostUserName()]){}
		foreach ($userArray->get() as $user) {

			if ($user -> getUserName() == $post -> getpostUserName()) {

				if ($user -> getProfilePic() == "default.jpg") {

					$this -> allPosts .= "<div class = 'loadpostclass'><div class = 'divprofilepic'>
									 <img class = 'postpic' src='upload/" . $user -> getProfilePic() . "' alt = 'pic''></div>
									 <p class = 'userNameClass'>" . $user -> getUserName() . ":</p>";
					break;
				} else {
					$this -> allPosts .= "<div class = 'loadpostclass'><div class = 'divprofilepic'>
									<img class = 'postpic' src='upload/" . $post -> getpostUserName() . "/profile/" . $user -> getProfilePic() . "' alt = 'pic''></div>
									<p class = 'userNameClass'>" . $user -> getUserName() . ":</p>";
					break;
				}
			}
		}
	}

	private function editOrComment($post) {

		if ($this -> wantToEditPost() && $this -> getPostID() == $post -> getpostID()) {
			$this -> allPosts .= $this -> EditMenu($post -> getcomment(), $post -> getpostID());
		} else {
			$this -> allPosts .= "<div class = 'commentClass'><p class = '" . self::$postClassName . "'>" . $post -> getcomment() . "</p></div>";
		}
	}

	private function showPic($post) {

		if ($post -> getpostPic() == null) {

		} else {
			$this -> allPosts .= "<div class = 'divpostpic'><a href =
				'upload/" . $post -> getpostUserName() . "/post/" . $post -> getpostPic() . "' title = 'pic'>
				<img class = 'postpic' src='upload/" . $post -> getpostUserName() . "/post/" . $post -> getpostPic() . "' alt = 'pic''></a></div>";
		}
	}

	private function buttontForUser($loginUser, $admin, $post) {

		if ($this -> wantToEditPost() && $this -> getPostID() == $post -> getpostID()) {

			$this -> allPosts .= $this -> doDeleteButton($post -> getpostID()) . "</div>";
		} else if ($loginUser == $admin) {

			$this -> allPosts .= $this -> doEditButton($post -> getpostID()) . $this -> doDeleteButton($post -> getpostID()) . "</div> ";
		} else if ($post -> getpostUserName() == $loginUser) {

			$this -> allPosts .= $this -> doEditButton($post -> getpostID()) . $this -> doDeleteButton($post -> getpostID()) . "</div> ";
		}
	}
}