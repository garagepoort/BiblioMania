<?php

namespace e2e\datasetbuilders;

class AuthorBuilder implements \CreateAuthorRequest
{

    private $name;
    private $dateOfBirth;
    private $dateOfDeath;
    private $imageUrl;

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getDateOfBirth()
    {
        return $this->dateOfBirth;
    }

    /**
     * @return mixed
     */
    public function getDateOfDeath()
    {
        return $this->dateOfDeath;
    }

    /**
     * @return mixed
     */
    public function getImageUrl()
    {
        return $this->imageUrl;
    }

    /**
     * @param mixed $name
     */
    public function withName($firstname, $infix, $lastname)
    {
        $this->name = new NameBuilder();
        $this->name
            ->withFirstname($firstname)
            ->withInfix($infix)
            ->withLastname($lastname);
        return $this;
    }

    /**
     * @param mixed $dateOfBirth
     */
    public function withDateOfBirth($day, $month, $year)
    {
        $this->dateOfBirth = new DateBuilder();
        $this->dateOfBirth
            ->withDay($day)
            ->withMonth($month)
            ->withYear($year);
        return $this;
    }

    /**
     * @param mixed $dateOfDeath
     */
    public function withDateOfDeath($day, $month, $year)
    {
        $this->dateOfDeath = new DateBuilder();
        $this->dateOfDeath
            ->withDay($day)
            ->withMonth($month)
            ->withYear($year);
        return $this;
    }

    /**
     * @param mixed $imageUrl
     */
    public function withImageUrl($imageUrl)
    {
        $this->imageUrl = $imageUrl;
        return $this;
    }
    
    
}
