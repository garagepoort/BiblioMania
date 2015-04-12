<?php

class AuthorInfoParameters {
    private $name;
    private $firstname;
    private $infix;
    private $date_of_birth;
    private $date_of_death;
    private $linked_book;
    private $oeuvre;
    private $image;

    function __construct($name, $firstname, $infix, Date $date_of_birth = null, Date $date_of_death = null, $linked_book, $image, $oeuvre)
    {
        $this->name = $name;
        $this->firstname = $firstname;
        $this->infix = $infix;
        $this->date_of_birth = $date_of_birth;
        $this->date_of_death = $date_of_death;
        $this->linked_book = $linked_book;
        $this->image = $image;
        $this->oeuvre = $oeuvre;
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

}