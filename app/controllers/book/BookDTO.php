<?php

class BookDTO {

    private $image;
    private $title;
    private $id;

    function __construct($image, $title, $id)
    {
        $this->image = $image;
        $this->title = $title;
        $this->id = $id;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getId()
    {
        return $this->id;
    }


}