<?php

class CoverInfoParameters {

    private $coverType;
    private $image;

    function __construct($coverType, $image)
    {
        $this->coverType = $coverType;
        $this->image = $image;
    }


    public function getImage()
    {
        return $this->image;
    }



    public function getCoverType()
    {
        return $this->coverType;
    }
}