<?php

namespace e2e\datasetbuilders;


class NameBuilder implements \NameRequest
{
    private $firstname;
    private $infix;
    private $lastname;

    /**
     * @return mixed
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * @return mixed
     */
    public function getInfix()
    {
        return $this->infix;
    }

    /**
     * @return mixed
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * @param mixed $firstname
     */
    public function withFirstname($firstname)
    {
        $this->firstname = $firstname;
        return $this;
    }

    /**
     * @param mixed $infix
     */
    public function withInfix($infix)
    {
        $this->infix = $infix;
        return $this;
    }

    /**
     * @param mixed $lastname
     */
    public function withLastname($lastname)
    {
        $this->lastname = $lastname;
        return $this;
    }


}