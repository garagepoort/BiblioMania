<?php

class AuthorFromJsonAdapter implements CreateAuthorRequest
{
    /** @var NameFromJsonAdapter */
    /** @required */
    private $name;
    /** @var string */
    private $image;
    /** @var DateFromJsonAdapter */
    private $dateOfBirth;
    /** @var DateFromJsonAdapter */
    private $dateOfDeath;

    function getImage()
    {
        return $this->image;
    }

    function getDateOfBirth()
    {
        return $this->dateOfBirth;
    }

    function getDateOfDeath()
    {
        return $this->dateOfDeath;
    }

    /**
     * @return NameFromJsonAdapter
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param NameFromJsonAdapter $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @param string $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }

    /**
     * @param DateFromJsonAdapter $dateOfBirth
     */
    public function setDateOfBirth($dateOfBirth)
    {
        $this->dateOfBirth = $dateOfBirth;
    }

    /**
     * @param DateFromJsonAdapter $dateOfDeath
     */
    public function setDateOfDeath($dateOfDeath)
    {
        $this->dateOfDeath = $dateOfDeath;
    }


}