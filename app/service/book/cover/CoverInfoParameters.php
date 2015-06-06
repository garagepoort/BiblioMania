<?php

class CoverInfoParameters {

    private $coverType;
    private $image;
    private $selfUpload;

    function __construct($coverType, $image, $selfUpload)
    {
        $this->coverType = $coverType;
        $this->image = $image;
        $this->selfUpload = $selfUpload;
    }


    public function getImage()
    {
        return $this->image;
    }



    public function getCoverType()
    {
        return $this->coverType;
    }

    public function isSelfUpload()
    {
        return $this->selfUpload;
    }


}