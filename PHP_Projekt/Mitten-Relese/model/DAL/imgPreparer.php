<?php

namespace imgPreparer;

class ImgPreparer {

	public function createFolder($folderPath, $loginUser) {

		if (is_dir("upload/" . $loginUser) == false) {
			mkdir("upload/" . $loginUser, 0755);
		}
		if (is_dir($folderPath) == false) {
			mkdir($folderPath, 0755);
		}
	}

	public function setPicName($folderPath, $pic) {

		$num = 1;
		$temp = explode(".", $pic["name"]);

		while (file_exists($folderPath . $pic["name"])) {
			if ($temp[0] !== $temp[0] . $num) {
				$pic["name"] = $temp[0] . $num . "." . $temp[1];
			}
			$num++;
		}
		return $pic['name'];
	}

	public function makeThumbnail($path, $filetype, $dest_imagex) {

		if (($filetype == "image/jpeg") || ($filetype == "image/jpg") || ($filetype == "image/pjpeg")) {

			$source_image = imagecreatefromjpeg($path);
		} else if (($filetype == "image/x-png") || ($filetype == "image/png")) {

			$source_image = imagecreatefrompng($path);
		}

		$source_imagex = imagesx($source_image);
		$source_imagey = imagesy($source_image);

		$dest_imagey = floor($source_imagey * ($dest_imagex / $source_imagex));

		$dest_image = imagecreatetruecolor($dest_imagex, $dest_imagey);

		imagecopyresampled($dest_image, $source_image, 0, 0, 0, 0, $dest_imagex, $dest_imagey, $source_imagex, $source_imagey);

		if (($filetype == "image/jpeg") || ($filetype == "image/jpg") || ($filetype == "image/pjpeg")) {

			imagejpeg($dest_image, $path, 80);
		} else if (($filetype == "image/x-png") || ($filetype == "image/png")) {

			imagepng($dest_image, $path, 9);
		}
	}

}
