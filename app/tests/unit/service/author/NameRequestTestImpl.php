<?php

class NameRequestTestImpl implements NameRequest
{

    private $firstname = 'firstname';
    private $infix = 'infix';
    private $lastname = 'lastname';

    function getFirstname()
    {
        return $this->firstname;
    }

    function getInfix()
    {
        return $this->infix;
    }

    function getLastname()
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