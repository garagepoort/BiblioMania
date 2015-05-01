<?php

class CoverInfoParameters {

    private $coverType;
    private $image;
    private $shouldCreateImage;

    function __construct($coverType, $image, $shouldCreateImage)
    {
        $this->coverType = $coverType;
        $this->image = $image;
        $this->shouldCreateImage = $shouldCreateImage;
    }


    public function getImage()
    {
        return $this->image;
    }



    public function getCoverType()
    {
        return $this->coverType;
    }

    public function getShouldCreateImage()
    {
        return $this->shouldCreateImage;
    }


}