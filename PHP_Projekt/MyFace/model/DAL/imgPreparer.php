<?php

namespace imgPreparer;

require_once 'settings.php';

class ImgPreparer {
	
	/**
	 * @var string
	 */	
	private static $png;

	
	/**
	 * @var string
	 */		
	private static $jpeg;
	
	/**
	 * @var string
	 */		
	private static $jpg;
	
	/**
	 * @var string
	 */	
	private static $name;
	
	/**
	 * @var string
	 */	
	private static $tmp_name;
	
	/**
	 * @var string
	 */		
	private static $image;
	
	/**
	 * @var string
	 */		
	private static $type;
	
	/**
	 * @var string
	 */		
	private static $size;
	
	/**
	 * @var string
	 */		
	private static $uploadPath;
	
	/**
	 * @var string
	 */		
	private static $pjpeg;
	
	/**
	 * @var string
	 */		
	private static $xpng;
	
	public function __construct(){
		
		self::$png = \settings\Settings::$png;
		self::$jpeg = \settings\Settings::$jpeg;
		self::$jpg = \settings\Settings::$jpg;
		self::$name = \settings\Settings::$name;
		self::$tmp_name = \settings\Settings::$tmp_name;
		self::$type = \settings\Settings::$type;
		self::$image = \settings\Settings::$image;
		self::$size = \settings\Settings::$size;
		self::$uploadPath = \settings\Settings::$uploadPath;
		self::$pjpeg = \settings\Settings::$pjpeg;
		self::$xpng = \settings\Settings::$xpng;
	}
	
	/**
	 * @param pic array
	 * @return bool
	 * if the picture is not valid return false
	 */
	public function validatePic($pic) {

		$allowedExts = array(self::$jpeg, self::$jpg, self::$png);
		$temp = explode(".", $pic[self::$name]);
		$extension = end($temp);

		 $file = $pic[self::$tmp_name];
    	if (file_exists($file)){
        		
        	$imagesizedata = getimagesize($file);
			
			if ($imagesizedata === false){
            	return false;
        	}
        	if ((($pic[self::$type] == self::$image."/".self::$jpeg) ||
				($pic[self::$type] == self::$image."/".self::$jpg) ||
				($pic[self::$type] == self::$image."/".self::$png)) && in_array($extension, $allowedExts)){
				
					if($imagesizedata['mime'] !== $pic[self::$type]){
						return false;
					}
					else{
						return true;
					}
			}
		}
		return false;
	}
	
	/**
	 * @param pic array
	 * @return bool
	 */
	public function checkPicSize($pic){
		
		 if($pic[self::$size] < 3000000){
		 	return true;
		 }
		 return false;
	}

	/**
	 * @param folderPath string
	 * @param loginUser string
	 * creates folder for the picture
	 */
	public function createFolder($folderPath, $loginUser) {

		if (is_dir(self::$uploadPath."/" . $loginUser) == false) {
			mkdir(self::$uploadPath."/" . $loginUser, 0755);
		}
		if (is_dir($folderPath) == false) {
			mkdir($folderPath, 0755);
		}
	}

	/**
	 * @param folderPath string
	 * @param pic array
	 * @return name string
	 * if the picturename exist a number will be added to the name
	 */
	public function setPicName($folderPath, $pic) {

		$num = 1;
		$temp = explode(".", $pic[self::$name]);

		while (file_exists($folderPath . $pic[self::$name])) {
			if ($temp[0] !== $temp[0] . $num) {
				$pic[self::$name] = $temp[0] . $num . "." . $temp[1];
			}
			$num++;
		}
		return $pic[self::$name];
	}

	/**
	 * @param path string
	 * @param filetype string
	 * @param int
	 * resise the picture
	 */
	public function makeThumbnail($path, $filetype, $dest_imagex) {

		if ($this->checkIfJpg($filetype)) {

			$source_image = imagecreatefromjpeg($path);
		}
		else if ($this->checkIfPng($filetype)) {

			$source_image = imagecreatefrompng($path);
		}

		$source_imagex = imagesx($source_image);
		$source_imagey = imagesy($source_image);

		$dest_imagey = floor($source_imagey * ($dest_imagex / $source_imagex));

		$dest_image = imagecreatetruecolor($dest_imagex, $dest_imagey);

		imagecopyresampled($dest_image, $source_image, 0, 0, 0, 0, $dest_imagex, $dest_imagey, $source_imagex, $source_imagey);

		if ($this->checkIfJpg($filetype)) {
			imagejpeg($dest_image, $path, 80);
		}
		else if ($this->checkIfPng($filetype)) {
			imagepng($dest_image, $path, 9);
		}
	}
	
	/**
	 * @param filetype string
	 * @return bool
	 * checks if the imgtype is jpg
	 */
	private function checkIfJpg($filetype){
		
		if(($filetype == self::$image."/".self::$jpeg) || ($filetype == self::$image."/".self::$jpg) ||
			 											  ($filetype == self::$image."/".self::$pjpeg)){
			return true;
		}
		else{
			return false;
		}
	}
	
	/**
	 * @param filetype string
	 * @return bool
	 * checks if the imgtype is png
	 */
	private function checkIfPng($filetype){
		if(($filetype == self::$image."/".self::$xpng) || ($filetype == self::$image."/".self::$png)){
			return true;
		}
		else{
			return false;
		}
	}
}