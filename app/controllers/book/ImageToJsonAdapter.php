<?php

class ImageToJsonAdapter
{

    private $image;
    private $spritePointer;
    private $useSpriteImage;
    private $imageHeight;
    private $imageWidth;

    /**
     * BookToJsonAdapter constructor.
     */
    public function __construct(Book $book)
    {
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