<?php

class CoverInfoParameters {

    private $coverType;
    private $image;
    private $imageSaveType;

    function __construct($coverType, $image, $imageSaveType)
    {
        $this->coverType = $coverType;
        $this->image = $image;
        $this->imageSaveType = $imageSaveType;
    }


    public function getImage()
    {
        return $this->image;
    }



    public function getCoverType()
    {
        return $this->coverType;
    }

    public function getImageSaveType()
    {
        return $this->imageSaveType;
    }


}