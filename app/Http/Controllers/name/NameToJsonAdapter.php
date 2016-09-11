<?php

class NameToJsonAdapter
{

    /** @var  string */
    /** @required */
    private $firstname;
    /** @var  string */
    /** @required */
    private $lastname;
    /** @var  string */
    private $infix;

    /**
     * NameToJsonAdapter constructor.
     * @param string $firstname
     * @param string $lastname
     * @param string $infix
     */
    public function __construct($firstname, $lastname, $infix)
    {
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->infix = $infix;
    }

    public function mapToJson()
    {
        return array(
            "firstname" => $this->firstname,
            "infix" => $this->infix,
            "lastname" => $this->lastname,
        );
    }
}