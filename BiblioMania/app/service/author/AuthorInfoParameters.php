<?php

class AuthorInfoParameters {
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
    private $shouldCreateImage;

    function __construct($name, $firstname, $infix, Date $date_of_birth = null, Date $date_of_death = null, $linked_book, $image, array $oeuvre = array(), $shouldCreateImage)
    {
        $this->name = $name;
        $this->firstname = $firstname;
        $this->infix = $infix;
        $this->date_of_birth = $date_of_birth;
        $this->date_of_death = $date_of_death;
        $this->linked_book = $linked_book;
        $this->image = $image;
        $this->oeuvre = $oeuvre;
        $this->shouldCreateImage = $shouldCreateImage;
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

    public function getShouldCreateImage()
    {
        return $this->shouldCreateImage;
    }

}