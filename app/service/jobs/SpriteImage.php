<?php

class SpriteImage
{

    private $images;
    private $spriteHeight;

    /**
     * SpriteImage constructor.
     * @param $images
     * @param $spriteHeight
     */
    public function __construct()
    {
        $this->images = array();
        $this->spriteHeight = 0;
    }

    /**
     * @return mixed
     */
    public function getImages()
    {
        return $this->images;
    }

    public function addImage(Image $image){
        array_push($this->images, $image);
        $this->spriteHeight = $this->spriteHeight + $image->getHeight();
    }

    /**
     * @return mixed
     */
    public function getSpriteHeight()
    {
        return $this->spriteHeight;
    }


}