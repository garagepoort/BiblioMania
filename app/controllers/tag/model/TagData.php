<?php

class TagData
{
    /** @var string */
    private $text;

    /**
     * @param string $name
     */
    public function setText($text)
    {
        $this->text = $text;
    }

    /**
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    public function toJson(){
        return array(
            "text"=>$this->text
        );
    }
}