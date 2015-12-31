<?php

class CreateAuthorRequestTestImpl implements CreateAuthorRequest
{
    private $name;
    private $imageUrl = 'imageUrl';
    private $dateOfBirth;
    private $dateOfDeath;

    /**
     * CreateAuthorRequestTestImpl constructor.
     */
    public function __construct()
    {
        $this->name = new NameRequestTestImpl();
        $this->dateOfBirth = new DateRequestTestImpl();
        $this->dateOfDeath = new DateRequestTestImpl();
    }

    /**
     * @return NameFromJsonAdapter
     */
    function getName()
    {
        return $this->name;
    }

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
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @param string $imageUrl
     */
    public function setImageUrl($imageUrl)
    {
        $this->imageUrl = $imageUrl;
    }

    /**
     * @param mixed $dateOfBirth
     */
    public function setDateOfBirth($dateOfBirth)
    {
        $this->dateOfBirth = $dateOfBirth;
    }

    /**
     * @param mixed $dateOfDeath
     */
    public function setDateOfDeath($dateOfDeath)
    {
        $this->dateOfDeath = $dateOfDeath;
    }

}