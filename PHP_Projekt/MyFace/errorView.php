<?php

namespace errorView;

require_once 'settings.php';
require_once 'master/masterView.php';
    
class ErrorView extends \masterView\MasterView{
	
	/**
	 * @var string
	 */
	private static $php_self;
	
	public function __construct(){
		
		self::$php_self = \settings\Settings::$PHP_SELF;
		
		$this->errorPage();
	}
	
	/**
	 * render the errorpage
	 */
	private function errorPage(){
		
		$content = "<div class='ErrorClass'>
						<h1 class='ErrorH1'>The page cannot be found or an unexpected error has accerd. Please click on the home link and try again.</h1>
					<div>
					<div class='errorLink'>
						<li>
							<a href='".$_SERVER[self::$php_self]."'>hem</a>
						</li>
					</div>";
		
		$this->rendHTML($content);
	}
}
