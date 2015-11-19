<?php

class NameFromJsonAdapter implements NameRequest
{

    /** @var  string */
    /** @var  required */
    private $firstname;
    /** @var  string */
    private $infix;
    /** @var  string */
    /** @var  required */
    private $lastname;

    public function getFirstname()
    {
        return $this->firstname;
    }

    public function getInfix()
    {
        return $this->infix;
    }

    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * @param string $firstname
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
    }

    /**
     * @param string $infix
     */
    public function setInfix($infix)
    {
        $this->infix = $infix;
    }

    /**
     * @param string $lastname
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
    }

}