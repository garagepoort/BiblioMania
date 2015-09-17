<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 19/06/15
 * Time: 21:13
 */

class Image {

    private $width;
    private $height;
    private $file;

    function __construct($width, $height, $file)
    {
        $this->width = $width;
        $this->height = $height;
        $this->file = $file;
    }

    public function getWidth()
    {
        return $this->width;
    }
    public function getHeight()
    {
        return $this->height;
    }
    public function getFile()
    {
        return $this->file;
    }




}