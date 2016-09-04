<?php

class TagFromJsonAdapter
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
}