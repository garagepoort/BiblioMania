<?php

class ImageController extends BaseController
{

    private $logger;

    /** @var ApiAuthenticationService */
    private $apiAuthenticationService;
    /** @var BookService */
    private $bookService;

    function __construct()
    {
        $this->apiAuthenticationService = App::make('ApiAuthenticationService');
        $this->bookService = App::make('BookService');
    }

    public function getBookImage($id)
    {
        $response = $this->apiAuthenticationService->checkUserAuthenticated();
        if ($response != null) {
            return $response;
        } else {
            $book = $this->bookService->find($id);
            $username = Auth::user()->username;
            $image = file_get_contents(public_path() . "/" . Config::get("properties.bookImagesLocation") . "/" . $username . "/" . $book->coverImage);
            return Response::make($image, 200, ['content-type' => 'image/jpg']);
        }
    }

    public function createSpriteForBooks()
    {
        ini_set('max_execution_time', 1000);
        ini_set('memory_limit', '-1');
        $users = User::all();
        $logger = new Katzgrau\KLogger\Logger(app_path() . '/storage/logs');
        $logger->info("STARTING CREATE SPRITE FOR USERS");
        foreach ($users as $user) {
            $folder = public_path() . "/" . Config::get("properties.bookImagesLocation") . "/" . $user->username;
            if (file_exists($folder)) {
                $logger->info("Starting sprite creation for user $user->username");
                images_to_sprite::create_sprite_for_book_images($folder, $user);
                $logger->info("End sprite creation for user $user->username");
            } else {
                $logger->info("No image folder for user: $user->username");
            }
        }
        $logger->info("END CREATE SPRITE FOR USERS");
        ini_set('max_execution_time', 30);
        ini_set('memory_limit', '128M');
    }

    public function createSpriteForAuthors()
    {
        ini_set('max_execution_time', 1000);
        ini_set('memory_limit', '-1');
        $logger = new Katzgrau\KLogger\Logger(app_path() . '/storage/logs');
        $folder = public_path() . "/" . Config::get("properties.authorImagesLocation");
        $logger->info("STARTING CREATE SPRITE FOR AUTHOR IMAGES");
        images_to_sprite::create_sprite_for_author_images($folder);
        $logger->info("END CREATE SPRITE FOR AUTHOR IMAGES");

        ini_set('max_execution_time', 30);
        ini_set('memory_limit', '128M');
    }
}