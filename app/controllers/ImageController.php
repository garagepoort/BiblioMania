<?php

class ImageController extends BaseController
{

    /** @var ApiAuthenticationService */
    private $apiAuthenticationService;
    /** @var BookService */
    private $bookService;
    /** @var  SpriteCreator $spriteCreator */
    private $spriteCreator;
    /** @var  \Katzgrau\KLogger\Logger */
    private $logger;

    function __construct()
    {
        $this->apiAuthenticationService = App::make('ApiAuthenticationService');
        $this->bookService = App::make('BookService');
        $this->spriteCreator = App::make('SpriteCreator');
        $this->logger = App::make('Logger');
    }

    public function getBookImage($id)
    {
        $response = $this->apiAuthenticationService->checkUserAuthenticated();
        if ($response != null) {
            return $response;
        } else {
            $book = $this->bookService->find($id);
            $image = file_get_contents(public_path() . "/" . Config::get("properties.bookImagesLocation") . "/" . $book->coverImage);
            return Response::make($image, 200, ['content-type' => 'image/jpg']);
        }
    }

    public function createSpriteForBooks()
    {
        $folder = public_path() . "/" . Config::get("properties.bookImagesLocation");
        $this->createSprite($folder, function(Image $image, $imageYPointer){
            $book = Book::where('coverImage', '=', $image->getFile())->first();
            if($book != null) {
                $book->spritePointer = $imageYPointer;
                $book->imageHeight = $image->getHeight();
                $book->imageWidth = $image->getWidth();
                $book->useSpriteImage = true;
                $book->save();
            }
        });
    }

    public function createSpriteForAuthors()
    {
        $folder = public_path() . "/" . Config::get("properties.authorImagesLocation");
        $this->createSprite($folder, function($image, $imageYPointer){
            $author = Author::where('image', '=', $image->getFile())->first();
            if($author != null){
                $author->spritePointer = $imageYPointer;
                $author->imageHeight = $image->getHeight();
                $author->imageWidth = $image->getWidth();
                $author->useSpriteImage = true;
                $author->save();
            }
        });
    }

    private function createSprite($folder, $onImageFound){
        ini_set('max_execution_time', 1000);
        ini_set('memory_limit', '-1');
        if (file_exists($folder)) {
            $this->spriteCreator->createSpriteForImages($folder, $onImageFound);
        } else {
            $this->logger->info("No image folder found: " . $folder);
        }
        ini_set('max_execution_time', 30);
        ini_set('memory_limit', '128M');
    }
}