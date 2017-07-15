<?php

class ImageController extends Controller
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
        $book = $this->bookService->find($id);
        if(file_exists(public_path() . "/" . Config::get("properties.bookImagesLocation") . "/" . $book->coverImage)){
            $image = file_get_contents(public_path() . "/" . Config::get("properties.bookImagesLocation") . "/" . $book->coverImage);
            return Response::make($image, 200, ['content-type' => 'image/jpg']);
        }
        return Response::make(202);
    }

    public function getAuthorImage($id)
    {
        $author = $this->authorService->find($id);
        if(file_exists(public_path() . "/" . Config::get("properties.authorImagesLocation") . "/" . $author->image)){
            $image = file_get_contents(public_path() . "/" . Config::get("properties.authorImagesLocation") . "/" . $author->image);
            return Response::make($image, 200, ['content-type' => 'image/jpg']);
        }
        return Response::make(202);
    }

    public function createSpriteForBooks()
    {
        ini_set('max_execution_time', 1000);
        ini_set('memory_limit', '-1');
        $folder = public_path() . "/" . Config::get("properties.bookImagesLocation");
        $images = $this->spriteCreator->getAllImageFileNamesFromFolder($folder);

        foreach($this->bookService->allBooks() as $book){
            if(!in_array($book->coverImage, $images, true)){
                $book->coverImage = "";
            }
            $book->useSpriteImage = false;
            $book->spritePointer = 0;
            $book->save();
        }

        $this->createSprite($folder, function(Image $image, $imageYPointer, $filename){
            $book = Book::where('coverImage', '=', $image->getFile())->first();
            if($book != null) {
                $book->spriteFileLocation = $filename;
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
        $folder = public_path() . "/" . Config::get("properties.authorImagesLocation");
        $images = $this->spriteCreator->getAllImageFileNamesFromFolder($folder);

        foreach($this->authorService->getAllAuthors() as $author){
            if(!in_array($author->image, $images, true)){
                $author->image = null;
            }
            $author->useSpriteImage = false;
            $author->spritePointer = 0;
            $author->save();
        }

        $this->createSprite($folder, function($image, $imageYPointer, $filename){
            $author = Author::where('image', '=', $image->getFile())->first();
            if($author != null){
                $author->spriteFileLocation = $filename;
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