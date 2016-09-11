<?php

class UpdateSerieRequestTestImpl implements UpdateSerieRequest
{

    private $id = 123;

    private $name = 'name';

    function getId()
    {
        return $this->id;
    }

    function getName()
    {
        return $this->name;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }


}