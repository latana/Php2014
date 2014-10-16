<?php

namespace errorView;
    
class ErrorView extends \basicView\BasicView{
	
	public function __construct(){
		
		$this->errorPage();
	}
	
	private function errorPage(){
		
		$content = "<h1>Sidan kan inte hittas... Är du säker på att du inte försökt hacka mig?</h1>
		<a href='http://127.0.0.1/Althona/?frontPage'>hem</a>";
		
		$this->rendHTML($content);
	}
}
