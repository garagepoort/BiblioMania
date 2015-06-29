<?php

class ImageController extends BaseController {

	private $logger;

	public function createSprite(){
		ini_set('max_execution_time', 1000);
		ini_set('memory_limit', '-1');
		$users = User::all();
		$logger = new Katzgrau\KLogger\Logger(app_path() . '/storage/logs');
		$logger->info("STARTING CREATE SPRITE FOR USERS");
		foreach($users as $user){
			$folder = public_path() . "/". Config::get("properties.bookImagesLocation") ."/" . $user->username;
			if(file_exists($folder)){
				$logger->info("Starting sprite creation for user $user->username");
				images_to_sprite::create_sprite_for_book_images($folder, $user);
				$logger->info("End sprite creation for user $user->username");
			}else{
				$logger->info("No image folder for user: $user->username");
			}
	//		$folder = public_path() . "/bookImages/test";
		}
		$logger->info("END CREATE SPRITE FOR USERS");
		$folder = public_path() . "/". Config::get("properties.authorImagesLocation");
		$logger->info("STARTING CREATE SPRITE FOR AUTHOR IMAGES");
		images_to_sprite::create_sprite_for_author_images($folder);
		$logger->info("END CREATE SPRITE FOR AUTHOR IMAGES");

		ini_set('max_execution_time', 30);
		ini_set('memory_limit', '128M');
	}
}