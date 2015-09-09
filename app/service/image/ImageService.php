<?php

class ImageService
{

    public function saveUploadImageForAuthor($image, Author $author)
    {
        $filename = str_random(8) . '_' . $author->name . '.jpg';
        $filename = StringUtils::clean($filename);
        $location = Config::get("properties.authorImagesLocation") . "/" . $filename;

        $image->move(Config::get("properties.authorImagesLocation"), $filename);
        $image = imagecreatefromjpeg($location);

        list($width, $height) = $this->resizeAndSaveImage($location, $image);
        $author->imageWidth = $width;
        $author->imageHeight = $height;
        $author->spritePointer = 0;
        return $filename;
    }

    public function saveUploadImageForBook($image, Book $book)
    {
        $filename = str_random(8) . '_' . $book->title . '.jpg';
        $filename = StringUtils::clean($filename);
        $location = Config::get("properties.bookImagesLocation") . "/" . Auth::user()->username . "/" . $filename;

        $image->move(Config::get("properties.bookImagesLocation") . "/" . Auth::user()->username, $filename);
        $image = imagecreatefromjpeg($location);
        list($width, $height) = $this->resizeAndSaveImage($location, $image);
        $book->imageWidth = $width;
        $book->imageHeight = $height;
        $book->spritePointer = 0;
        return $filename;
    }

    public function saveAuthorImageFromUrl($url, Author $author)
    {
        $imageFilename = str_random(8) . '_' . $author->name . '.jpg';
        $imageFilename = StringUtils::clean($imageFilename);
        $imageLocation = Config::get("properties.authorImagesLocation") . '/' . $imageFilename;
        list($width, $height) = $this->saveImageFromUrl($url, $imageLocation);
        $author->imageWidth = $width;
        $author->imageHeight = $height;
        $author->spritePointer = 0;
        return $imageFilename;
    }

    public function saveBookImageFromUrl($url, Book $book)
    {
        $imageFilename = str_random(8) . '_' . $book->title . '.jpg';
        $imageFilename = StringUtils::clean($imageFilename);
        $imageLocation = Config::get("properties.bookImagesLocation") . "/" . Auth::user()->username . '/' . $imageFilename;
        list($width, $height) = $this->saveImageFromUrl($url, $imageLocation);
        $book->imageWidth = $width;
        $book->imageHeight = $height;
        $book->spritePointer = 0;
        return $imageFilename;
    }

    public function saveImageFromUrl($url, $imageLocation)
    {
        $img = file_get_contents($url);
        $im = imagecreatefromstring($img);

        return $this->resizeAndSaveImage($imageLocation, $im);
    }

    function resizeAndSaveImage($location, $image)
    {
        $newwidth = '142';
        $newheight = '226';
        $newImage = $this->resize_image_max($image, $newwidth, $newheight);
        $w = imagesx($newImage); //current width
        $h = imagesy($newImage);
        imagejpeg($newImage, $location); //save image as jpg
        imagedestroy($image);
        return array($w, $h);
    }

    public function removeAuthorImage($image)
    {
        $fullImagePath = Config::get("properties.authorImagesLocation") . "/" . $image;
        if (!StringUtils::isEmpty($image)) {
            if (file_exists($fullImagePath)) {
                unlink($fullImagePath);
            }
        }
    }

    public function removeBookImage($image)
    {
        $fullImagePath = Config::get("properties.bookImagesLocation") . "/" . $image;
        if (!StringUtils::isEmpty($image)) {
            if (file_exists($fullImagePath)) {
                unlink($fullImagePath);
            }
        }
    }

    function resize_image_max($image, $max_width, $max_height)
    {
        $w = imagesx($image); //current width
        $h = imagesy($image); //current height
        if ((!$w) || (!$h)) {
            $GLOBALS['errors'][] = 'Image couldn\'t be resized because it wasn\'t a valid image.';
            return false;
        }

        if (($w <= $max_width) && ($h <= $max_height)) {
            return $image;
        } //no resizing needed

        //try max height first...
        $ratio = $max_height / $h;
        $new_h = $max_height;
        $new_w = $w * $ratio;

        //if that didn't work
        if ($new_w > $max_width) {
            $ratio = $max_width / $w;
            $new_w = $max_width;
            $new_h = $h * $ratio;
        }

        $new_image = imagecreatetruecolor($new_w, $new_h);
        imagecopyresampled($new_image, $image, 0, 0, 0, 0, $new_w, $new_h, $w, $h);
        return $new_image;
    }

}