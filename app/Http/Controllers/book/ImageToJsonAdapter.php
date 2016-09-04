<?php

class ImageToJsonAdapter
{

    private $image;
    private $spritePointer;
    private $useSpriteImage;
    private $imageHeight;
    private $imageWidth;

    public function __construct()
    {
    }

    public function fromBook(Book $book){
        $baseUrl = URL::to('/');
        $bookImage = $baseUrl . "/bookImages/" . $book->spriteFileLocation;

        if ($book->useSpriteImage == false) {
            $bookImage = $baseUrl . "/bookImages/" . $book->coverImage;
        }

        $this->image = $bookImage;
        $this->spritePointer = $book->spritePointer;
        $this->useSpriteImage = $book->useSpriteImage == true;
        $this->imageHeight = $book->imageHeight;
        $this->imageWidth = $book->imageWidth;
    }

    public function fromAuthor(Author $author){
        $baseUrl = URL::to('/');
        $authorImage = $baseUrl . "/" . Config::get("properties.authorImagesLocation") . "/" . $author->spriteFileLocation;

        if ($author->useSpriteImage == false) {
            $authorImage = $baseUrl . "/". Config::get("properties.authorImagesLocation") . "/" . $author->image;
        }

        $this->image = $authorImage;
        $this->spritePointer = $author->spritePointer;
        $this->useSpriteImage = $author->useSpriteImage;
        $this->imageHeight = $author->imageHeight;
        $this->imageWidth = $author->imageWidth;
    }

    public function mapToJson(){
        return array(
            "image"=>$this->image,
            "imageHeight"=>$this->imageHeight,
            "imageWidth"=>$this->imageWidth,
            "useSpriteImage" => $this->useSpriteImage,
            "spritePointer" => $this->spritePointer,
        );
    }

}