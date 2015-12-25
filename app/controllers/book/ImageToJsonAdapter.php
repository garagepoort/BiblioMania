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
        $username = Auth::user()->username;
        $baseUrl = URL::to('/');
        $bookImage = $baseUrl . "/bookImages/" . $username . "/sprite.png";

        if ($book->useSpriteImage == false) {
            $bookImage = $baseUrl . "/bookImages/" . $username . "/" . $book->coverImage;
        }

        $this->image = $bookImage;
        $this->spritePointer = $book->spritePointer;
        $this->useSpriteImage = $book->useSpriteImage;
        $this->imageHeight = $book->imageHeight;
        $this->imageWidth = $book->imageWidth;
    }

    public function fromAuthor(Author $author){
        $baseUrl = URL::to('/');
        $authorImage = $baseUrl . "/authorImages/sprite.png";

        if ($author->useSpriteImage == false) {
            $authorImage = $baseUrl . "/authorImages/" . $author->image;
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