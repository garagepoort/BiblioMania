<?php

class ImageController extends BaseController {

	private $logger;

	public function scaleImages(){
	}

	public function createSprite(){
		ini_set('max_execution_time', 300);
		ini_set('memory_limit', '-1');
		$users = User::all();

		foreach($users as $user){
			$folder = public_path() . "/". Config::get("properties.bookImagesLocation") ."/" . $user->username;
			if(file_exists($folder)){
				images_to_sprite::create_sprite_for_book_images($folder, $user);
			}
	//		$folder = public_path() . "/bookImages/test";
		}
		$folder = public_path() . "/". Config::get("properties.authorImagesLocation");
		images_to_sprite::create_sprite_for_author_images($folder);
		ini_set('max_execution_time', 30);
		ini_set('memory_limit', '128M');
	}
}