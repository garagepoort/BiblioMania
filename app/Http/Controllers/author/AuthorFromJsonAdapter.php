<?php

class AuthorFromJsonAdapter implements CreateAuthorRequest
{
    /** @var NameFromJsonAdapter */
    /** @required */
    private $name;
    /** @var string */
    private $imageUrl;
    /** @var DateFromJsonAdapter */
    private $dateOfBirth;
    /** @var DateFromJsonAdapter */
    private $dateOfDeath;

    function getImageUrl()
    {
        return $this->imageUrl;
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
    public function setImageUrl($image)
    {
        $this->imageUrl = $image;
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