<?php

class ImageController extends BaseController {

	private $logger;

	public function scaleImages(){
	}

	public function createSprite(){
		ini_set('max_execution_time', 300);
		ini_set('memory_limit', '-1');
		$folder = public_path() . "/bookImages/" . Auth::user()->username;
//		$folder = public_path() . "/bookImages/test";
		$class = new images_to_sprite($folder,'sprite', 142);
		$class->create_sprite();
		ini_set('max_execution_time', 30);
		ini_set('memory_limit', '128M');
	}
}