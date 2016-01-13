<?php

class ImageController extends BaseController
{

    /** @var ApiAuthenticationService */
    private $apiAuthenticationService;
    /** @var BookService */
    private $bookService;
    /** @var BookElasticIndexer */
    private $bookElasticIndexer;
    /** @var  AuthorService */
    private $authorService;
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
        $this->authorService = App::make('AuthorService');
        $this->bookElasticIndexer = App::make('BookElasticIndexer');
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
        ini_set('max_execution_time', 1000);
        ini_set('memory_limit', '-1');
        foreach($this->bookService->allBooks() as $book){
            $book->useSpriteImage = false;
            $book->save();
        }
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
        $this->bookElasticIndexer->indexBooks();

        ini_set('max_execution_time', 30);
        ini_set('memory_limit', '128M');
    }

    public function createSpriteForAuthors()
    {
        ini_set('max_execution_time', 1000);
        ini_set('memory_limit', '-1');
        foreach($this->authorService->getAllAuthors() as $author){
            $author->useSpriteImage = false;
            $author->save();
        }
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

        ini_set('max_execution_time', 30);
        ini_set('memory_limit', '128M');
    }

    private function createSprite($folder, $onImageFound){
        if (file_exists($folder)) {
            $this->spriteCreator->createSpriteForImages($folder, $onImageFound);
        } else {
            $this->logger->info("No image folder found: " . $folder);
        }
    }
}