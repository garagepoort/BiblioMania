<?php

class AuthorInfoParameters {
    public static $TYPE_IMAGE_UPLOAD = "IMAGE_UPLOAD";
    public static $TYPE__IMAGE_URL = "IMAGE_URL";

    /** @var  String */
    private $name;
    /** @var  String */
    private $firstname;
    /** @var  String */
    private $infix;
    /** @var  Date */
    private $date_of_birth;
    /** @var  Date */
    private $date_of_death;
    /** @var  String */
    private $linked_book;
    /** @var  BookFromAuthorParameters[] */
    private $oeuvre;
    private $image;
    private $selfUpload;

    function __construct($name, $firstname, $infix, Date $date_of_birth = null, Date $date_of_death = null, $linked_book, $image, array $oeuvre = array(), $selfUpload)
    {
        $this->name = trim($name);
        $this->firstname = trim($firstname);
        $this->infix = trim($infix);
        $this->date_of_birth = $date_of_birth;
        $this->date_of_death = $date_of_death;
        $this->linked_book = $linked_book;
        $this->image = $image;
        $this->oeuvre = $oeuvre;
        $this->selfUpload = $selfUpload;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getFirstname()
    {
        return $this->firstname;
    }

    public function getInfix()
    {
        return $this->infix;
    }

    public function getDateOfBirth()
    {
        return $this->date_of_birth;
    }

    public function getDateOfDeath()
    {
        return $this->date_of_death;
    }

    public function getLinkedBook()
    {
        return $this->linked_book;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function getOeuvre()
    {
        return $this->oeuvre;
    }

    public function isSelfUpload()
    {
        return $this->selfUpload;
    }


}