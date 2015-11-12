<?php

class GenreData
{
    /** @var string */
    private $label;
    /** @var  string[] */
    private $children;

    /**
     * @param string $label
     */
    public function setLabel($label)
    {
        $this->label = $label;
    }

    /**
     * @param string[] $children
     */
    public function setChildren($children)
    {
        $this->children = $children;
    }

    public function toJson(){
        return array(
            "label"=>$this->label,
            "children"=>$this->children
        );
    }
}